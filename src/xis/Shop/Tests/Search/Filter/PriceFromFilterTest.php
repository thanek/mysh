<?php
namespace xis\Shop\Tests\Search\Filter;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Search\Filter\PriceFromFilter;
use xis\Shop\Search\Parameter\FilterSet;

class PriceFromFilterTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldSetValueOnFilter()
    {
        $filter = new PriceFromFilter(123.23);

        /** @var FilterSet|ObjectProphecy $filterSet */
        $filterSet = $this->prophesize('xis\Shop\Search\Parameter\FilterSet');
        $filterSet->setPriceFrom(123.23)->shouldBeCalled();

        $filter->updateFilterSet($filterSet->reveal());
    }

    /**
     * @test
     */
    public function shouldReturnItsName()
    {
        $filter = new PriceFromFilter('123.20');

        $name = $filter->getName();

        $this->assertSame('price from', $name);
    }

    /**
     * @test
     */
    public function shouldReturnItsValue()
    {
        $filter = new PriceFromFilter(123.40);

        $actualValue = $filter->getValue();

        $this->assertSame(123.40, $actualValue);
    }
}