<?php
namespace xis\ShopCoreBundle\Tests\Twig;

use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Bundle\FrameworkBundle\Templating\Helper\RouterHelper;
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
    public function getFunctionsShouldContainPagerFunction()
    {
        $functions = $this->pagerExtension->getFunctions();

        $this->assertArrayHasKey('pager', $functions);
    }

    /**
     * @test
     */
    public function getNameShouldReturnPagerName()
    {
        $name = $this->pagerExtension->getName();

        $this->assertEquals('pager', $name);
    }

    /**
     * @test
     */
    public function getPagerShouldReturnShortPager()
    {
        $pager = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\Pager');
        $pager->getCount()->willReturn(1);
        $pager->getPageCount()->willReturn(1);
        $pager->getCurrentPage()->willReturn(1);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal());
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ *1* ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function getPagerShouldReturnValidHtml()
    {
        $this->router->generate(new AnyValuesToken(), new AnyValuesToken())->willReturn('someUrl');

        $pager = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\Pager');
        $pager->getCount()->willReturn(100);
        $pager->getPageCount()->willReturn(2);
        $pager->getCurrentPage()->willReturn(1);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal());

        $this->assertEquals(
            '<ul class="pager"><li><span>1</span></li><li><a href="someUrl">2</a></li></ul>',
            $pagerHtml
        );
    }

    /**
     * @test
     */
    public function getPagerShouldGenerateValidLinks()
    {
        $this->router->generate('products_all', array('page' => 1))->willReturn('http://some.pla.ce/all?page=1');
        $this->router->generate('products_all', array('page' => 3))->willReturn('http://some.pla.ce/all?page=3');

        $pager = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\Pager');
        $pager->getCount()->willReturn(100);
        $pager->getPageCount()->willReturn(3);
        $pager->getCurrentPage()->willReturn(2);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal());
        $ret = preg_match_all('|href="(\S+)"|', $pagerHtml, $m);

        $this->assertEquals(true, $ret);
        $this->assertEquals(2, count($m[1]));
        $this->assertEquals('http://some.pla.ce/all?page=1', $m[1][0]);
        $this->assertEquals('http://some.pla.ce/all?page=3', $m[1][1]);
    }

    /**
     * @test
     */
    public function getPagerShouldReturnLongPager()
    {
        $pager = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\Pager');
        $pager->getCount()->willReturn(100);
        $pager->getPageCount()->willReturn(10);
        $pager->getCurrentPage()->willReturn(1);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal());
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ *1* @2@ @3@ @4@ @5@ @6@ *...* @10@ ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function getPagerShouldReturnLongPagerWithFifthElementSelected()
    {
        $pager = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\Pager');
        $pager->getCount()->willReturn(100);
        $pager->getPageCount()->willReturn(10);
        $pager->getCurrentPage()->willReturn(5);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal());
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ @1@ @2@ @3@ @4@ *5* @6@ @7@ @8@ @9@ @10@ ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function getPagerShouldShowDotsOnTheLeftForBigPageNumber()
    {
        $pager = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\Pager');
        $pager->getCount()->willReturn(100);
        $pager->getPageCount()->willReturn(10);
        $pager->getCurrentPage()->willReturn(8);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal());
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ @1@ *...* @3@ @4@ @5@ @6@ @7@ *8* @9@ @10@ ]', $pagerTxt);
    }

    /**
     * @test
     */
    public function getPagerShouldShowNoDotsForAveragePager()
    {
        $pager = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\Pager');
        $pager->getCount()->willReturn(100);
        $pager->getPageCount()->willReturn(5);
        $pager->getCurrentPage()->willReturn(3);

        $pagerHtml = $this->pagerExtension->pager($pager->reveal());
        $pagerTxt = $this->stripTags($pagerHtml);

        $this->assertEquals('[ @1@ @2@ *3* @4@ @5@ ]', $pagerTxt);
    }

    /**
     * Returns text pager represenation.
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
}