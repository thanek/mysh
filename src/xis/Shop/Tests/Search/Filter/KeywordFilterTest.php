<?php
namespace xis\Shop\Tests\Search\Filter;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Search\Filter\KeywordFilter;
use xis\Shop\Search\Parameter\FilterSet;

class KeywordFilterTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldSetValueOnFilter()
    {
        $filter = new KeywordFilter('foo');

        /** @var FilterSet|ObjectProphecy $filterSet */
        $filterSet = $this->prophesize('xis\Shop\Search\Parameter\FilterSet');
        $filterSet->setKeyword('foo')->shouldBeCalled();

        $filter->updateFilterSet($filterSet->reveal());
    }
} 