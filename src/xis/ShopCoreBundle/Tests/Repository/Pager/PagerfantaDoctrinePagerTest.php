<?php
namespace xis\ShopCoreBundle\Tests\Repository\Pager;

use Pagerfanta\Pagerfanta;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Repository\Pager\Pager;
use xis\ShopCoreBundle\Repository\Pager\PagerfantaDoctrinePager;

class PagerfantaDoctrinePagerTest extends ProphecyTestCase
{
    /** @var  Pagerfanta|ObjectProphecy */
    private $pagerFanta;
    /** @var Pager */
    private $pager;

    public function setup()
    {
        parent::setup();

        $this->pagerFanta = $this->prophesize('Pagerfanta\Pagerfanta');
        $this->pager = new PagerfantaDoctrinePager($this->pagerFanta->reveal());
    }

    /**
     * @test
     */
    public function setLimitShouldInvokePagerfanta()
    {
        $this->pager->setLimit(10);
        $this->pagerFanta->setMaxPerPage(10)->shouldHaveBeenCalled();
    }

    /**
     * @test
     */
    public function setCurrentPageShouldInvokePagerfanta()
    {
        $this->pager->setCurrentPage(10);
        $this->pagerFanta->setCurrentPage(10)->shouldHaveBeenCalled();
    }

    /**
     * @test
     */
    public function getCurrentPageShouldInvokePagerfanta()
    {
        $this->pagerFanta->getCurrentPage()->willReturn(7);

        $ret = $this->pager->getCurrentPage();

        $this->assertEquals(7, $ret);
    }

    /**
     * @test
     */
    public function getCountShouldInvokePagerfanta()
    {
        $this->pagerFanta->getNbResults()->willReturn(11);

        $ret = $this->pager->getCount();

        $this->assertEquals(11, $ret);
    }

    /**
     * @test
     */
    public function getPageCountInvokePagerfanta()
    {
        $this->pagerFanta->getNbPages()->willReturn(5);

        $ret = $this->pager->getPageCount();

        $this->assertEquals(5, $ret);
    }

    /**
     * @test
     */
    public function getNextPageShouldInvokePagerfanta()
    {
        $this->pagerFanta->getNextPage()->willReturn(6);

        $ret = $this->pager->getNextPage();

        $this->assertEquals(6, $ret);
    }

    /**
     * @test
     */
    public function getPreviousPageShouldInvokePagerfanta()
    {
        $this->pagerFanta->getPreviousPage()->willReturn(4);

        $ret = $this->pager->getPreviousPage();

        $this->assertEquals(4, $ret);
    }

    /**
     * @test
     */
    public function getResultsShouldInvokePagerfanta()
    {
        $this->pagerFanta->getCurrentPageResults()->willReturn(array('foo' => 'bar'));

        $ret = $this->pager->getResults();

        $this->assertEquals(array('foo' => 'bar'), $ret);
    }
}