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
} 