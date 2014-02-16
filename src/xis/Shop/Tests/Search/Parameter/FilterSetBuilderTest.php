<?php
namespace xis\Shop\Tests\Search\Parameter;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Search\Filter\Filter;
use xis\Shop\Search\Parameter\FilterSetBuilder;

class FilterSetBuilderTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldUpdateFilterSetWhenAddingParameter()
    {
        /** @var Filter|ObjectProphecy $filter */
        $filter = $this->prophesize('xis\Shop\Search\Filter\Filter');

        $filterSetBuilder = new FilterSetBuilder();
        $filter->updateFilterSet($filterSetBuilder->getFilterSet())->shouldBeCalled();

        $filterSetBuilder->addFilter($filter->reveal());
    }

    /**
     * @test
     */
    public function shouldAddCollectionOfParameters()
    {
        /** @var Filter|ObjectProphecy $filter */
        $filter1 = $this->prophesize('xis\Shop\Search\Filter\Filter');
        /** @var Filter|ObjectProphecy $filter */
        $filter2 = $this->prophesize('xis\Shop\Search\Filter\Filter');

        $filterSetBuilder = new FilterSetBuilder();
        $filter1->updateFilterSet($filterSetBuilder->getFilterSet())->shouldBeCalled();
        $filter2->updateFilterSet($filterSetBuilder->getFilterSet())->shouldBeCalled();

        $filterSetBuilder->addFilters(array($filter1->reveal(), $filter2->reveal()));
    }

} 