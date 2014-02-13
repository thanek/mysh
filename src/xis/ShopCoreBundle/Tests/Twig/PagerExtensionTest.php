<?php
namespace xis\ShopCoreBundle\Tests\Twig;

use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper;
use xis\Shop\Repository\Pager\Pager;
use xis\ShopCoreBundle\Twig\PagerExtension;

class PagerExtensionTest extends ProphecyTestCase
{
    /** @var PagerExtension */
    private $pagerExtension;
    /** @var RouterHelper|ObjectProphecy */
    private $router;

    public function setup()
    {
        parent::setup();
        $this->router = $this->prophesize('Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper');

        $this->pagerExtension = new PagerExtension($this->router->reveal());
    }

    /**
     * @test
     */
    public function shouldContainPagerFunctionInFunctionsList()
    {
        $functions = $this->pagerExtension->getFunctions();

        $this->assertCount(1, $functions);
        $this->assertSame('pager', $functions[0]->getName());
    }

    /**
     * @test
     */
    public function shouldReturnPagerName()
    {
        $name = $this->pagerExtension->getName();

        $this->assertEquals('pager', $name);
    }

    /**
     * @test
     */
    public function shouldReturnValidHtml()
    {
        $this->router->generate('all', new AnyValuesToken())->willReturn('someUrl');

        $pager = $this->getPagerMock(100, 2, 1);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'all');

        $this->assertEquals(
            '<ul class="pager"><li><span>1</span></li><li><a href="someUrl">2</a></li></ul>',
            $pagerHtml
        );
    }


    /**
     * @test
     */
    public function shouldGenerateValidLinks()
    {
        $this->router->generate('products_all', array('page' => 1))->willReturn('http://some.pla.ce/all?page=1');
        $this->router->generate('products_all', array('page' => 3))->willReturn('http://some.pla.ce/all?page=3');

        $pager = $this->getPagerMock(100, 3, 2);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'products_all');
        $ret = preg_match_all('|href="(\S+)"|', $pagerHtml, $m);

        $this->assertEquals(true, $ret);
        $this->assertEquals(2, count($m[1]));
        $this->assertEquals('http://some.pla.ce/all?page=1', $m[1][0]);
        $this->assertEquals('http://some.pla.ce/all?page=3', $m[1][1]);
    }


    /**
     * @test
     */
    public function shouldGenerateLinksWithCustomPageParamName()
    {
        $this->router->generate('home', array('strona' => 1))->willReturn('http://some.pla.ce/all?strona=1');
        $this->router->generate('home', array('strona' => 3))->willReturn('http://some.pla.ce/all?strona=3');

        $pager = $this->getPagerMock(100, 3, 2);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'home', 'strona');
        $ret = preg_match_all('|href="(\S+)"|', $pagerHtml, $m);

        $this->assertEquals(true, $ret);
        $this->assertEquals(2, count($m[1]));
        $this->assertEquals('http://some.pla.ce/all?strona=1', $m[1][0]);
        $this->assertEquals('http://some.pla.ce/all?strona=3', $m[1][1]);
    }

    /**
     * @test
     */
    public function shouldReturnShortPagerForSinglePageResult()
    {
        $pager = $this->getPagerMock(1, 1, 1);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'all');
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ *1* ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function shouldReturnLongPagerForManyResults()
    {
        $pager = $this->getPagerMock(100, 10, 1);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'all');
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ *1* @2@ @3@ @4@ @5@ @6@ *...* @10@ ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function shouldReturnLongPagerWithFifthElementSelected()
    {
        $pager = $this->getPagerMock(100, 10, 5);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'all');
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ @1@ @2@ @3@ @4@ *5* @6@ @7@ @8@ @9@ @10@ ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function shouldShowDotsOnTheLeftForBigPageNumber()
    {
        $pager = $this->getPagerMock(100, 10, 8);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'all');
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ @1@ *...* @3@ @4@ @5@ @6@ @7@ *8* @9@ @10@ ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function shouldShowDotsOnTheRightForSmallPageNumber()
    {
        $pager = $this->getPagerMock(100, 10, 2);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'all');
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ @1@ *2* @3@ @4@ @5@ @6@ @7@ *...* @10@ ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function shouldShowNoDotsForAveragePager()
    {
        $pager = $this->getPagerMock(100, 5, 3);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal(), 'all');
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ @1@ @2@ *3* @4@ @5@ ]', $pagerTxt);
    }

    /**
     * Returns text pager representation.
     *
     * Example:
     * @1@ - the first page is a link
     * *3* - the third page is plain text (current page)
     *
     * @param $txt
     * @return mixed
     */
    protected function stripTags($txt)
    {
        $txt = preg_replace('|<ul[^>]*>|', '[ ', $txt);
        $txt = preg_replace('|</ul>|', ']', $txt);
        $txt = preg_replace('|<li[^>]*>|', '', $txt);
        $txt = preg_replace('|</li>|', '', $txt);
        $txt = preg_replace('|<span[^>]*>|', '*', $txt);
        $txt = preg_replace('|</span>|', '* ', $txt);
        $txt = preg_replace('|<a[^>]*>|', '@', $txt);
        $txt = preg_replace('|</a>|', '@ ', $txt);
        return $txt;
    }

    /**
     * @param int $count
     * @param int $pageCount
     * @param int $currentPage
     *
     * @return Pager|ObjectProphecy
     */
    protected function getPagerMock($count, $pageCount, $currentPage)
    {
        $pager = $this->prophesize('xis\Shop\Repository\Pager\Pager');
        $pager->getCount()->willReturn($count);
        $pager->getPageCount()->willReturn($pageCount);
        $pager->getCurrentPage()->willReturn($currentPage);
        return $pager;
    }
}