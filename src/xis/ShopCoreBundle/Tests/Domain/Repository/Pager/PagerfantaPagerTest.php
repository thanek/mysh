<?php
namespace xis\ShopCoreBundle\Tests\Domain\Repository\Pager;

use Pagerfanta\Pagerfanta;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Domain\Repository\Pager\Pager;
use xis\ShopCoreBundle\Domain\Repository\Pager\PagerfantaPager;

class PagerfantaPagerTest extends ProphecyTestCase
{
    /** @var  Pagerfanta|ObjectProphecy */
    private $pagerFanta;
    /** @var Pager */
    private $pager;

    public function setup()
    {
        parent::setup();

        $this->pagerFanta = $this->prophesize('Pagerfanta\Pagerfanta');
        $this->pager = new PagerfantaPager($this->pagerFanta->reveal());
    }

    /**
     * @test
     */
    public function shouldSetLimit()
    {
        $this->pager->setLimit(10);
        $this->pagerFanta->setMaxPerPage(10)->shouldHaveBeenCalled();
    }

    /**
     * @test
     */
    public function shouldSetCurrentPage()
    {
        $this->pager->setCurrentPage(10);
        $this->pagerFanta->setCurrentPage(10)->shouldHaveBeenCalled();
    }

    /**
     * @test
     */
    public function shouldGetCurrentPage()
    {
        $this->pagerFanta->getCurrentPage()->willReturn(7);

        $ret = $this->pager->getCurrentPage();

        $this->assertEquals(7, $ret);
    }

    /**
     * @test
     */
    public function shouldGetCount()
    {
        $this->pagerFanta->getNbResults()->willReturn(11);

        $ret = $this->pager->getCount();

        $this->assertEquals(11, $ret);
    }

    /**
     * @test
     */
    public function shouldGetPageCount()
    {
        $this->pagerFanta->getNbPages()->willReturn(5);

        $ret = $this->pager->getPageCount();

        $this->assertEquals(5, $ret);
    }

    /**
     * @test
     */
    public function shouldGetNextPage()
    {
        $this->pagerFanta->getNextPage()->willReturn(6);

        $ret = $this->pager->getNextPage();

        $this->assertEquals(6, $ret);
    }

    /**
     * @test
     */
    public function shouldGetPreviousPage()
    {
        $this->pagerFanta->getPreviousPage()->willReturn(4);

        $ret = $this->pager->getPreviousPage();

        $this->assertEquals(4, $ret);
    }

    /**
     * @test
     */
    public function shouldGetResults()
    {
        $this->pagerFanta->getCurrentPageResults()->willReturn(array('foo' => 'bar'));

        $ret = $this->pager->getResults();

        $this->assertEquals(array('foo' => 'bar'), $ret);
    }
}