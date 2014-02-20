<?php
namespace xis\Shop\Tests\Search\Filter;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Search\Filter\PriceToFilter;
use xis\Shop\Search\Parameter\FilterSet;

class PriceToFilterTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldSetValueOnFilter()
    {
        $filter = new PriceToFilter(234.34);

        /** @var FilterSet|ObjectProphecy $filterSet */
        $filterSet = $this->prophesize('xis\Shop\Search\Parameter\FilterSet');
        $filterSet->setPriceTo(234.34)->shouldBeCalled();

        $filter->updateFilterSet($filterSet->reveal());
    }

    /**
     * @test
     */
    public function shouldReturnItsName()
    {
        $filter = new PriceToFilter(123.30);

        $name = $filter->getName();

        $this->assertSame('price to', $name);
    }


    /**
     * @test
     */
    public function shouldReturnItsValue()
    {
        $filter = new PriceToFilter(123.40);

        $actualValue = $filter->getValue();

        $this->assertSame(123.40, $actualValue);
    }
}