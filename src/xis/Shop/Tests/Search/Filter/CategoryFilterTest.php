<?php
namespace xis\Shop\Tests\Search\Filter;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Entity\Category;
use xis\Shop\Search\Filter\CategoryFilter;
use xis\Shop\Search\Parameter\FilterSet;

class CategoryFilterTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldSetValueOnFilter()
    {
        $category = new Category();
        $filter = new CategoryFilter($category);

        /** @var FilterSet|ObjectProphecy $filterSet */
        $filterSet = $this->prophesize('xis\Shop\Search\Parameter\FilterSet');
        $filterSet->setCategory($category)->shouldBeCalled();

        $filter->updateFilterSet($filterSet->reveal());
    }

    /**
     * @test
     */
    public function shouldReturnItsName()
    {
        $filter = new CategoryFilter(new Category());

        $name = $filter->getName();

        $this->assertSame('category', $name);
    }

    /**
     * @test
     */
    public function shouldReturnItsValue()
    {
        $category = new Category();
        $category->setName('foo');
        $filter = new CategoryFilter($category);

        $actualValue = $filter->getValue();

        $this->assertSame('foo', $actualValue);
    }
} 