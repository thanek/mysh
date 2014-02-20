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

    /**
     * @test
     */
    public function shouldReturnItsName()
    {
        $filter = new KeywordFilter('foo');

        $name = $filter->getName();

        $this->assertSame('keyword', $name);
    }

    /**
     * @test
     */
    public function shouldReturnItsValue()
    {
        $filter = new KeywordFilter('foo');

        $actualValue = $filter->getValue();

        $this->assertSame('foo', $actualValue);
    }
}