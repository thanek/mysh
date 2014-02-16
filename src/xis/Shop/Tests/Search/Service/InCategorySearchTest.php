<?php
namespace xis\Shop\Tests\Search\Service;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\Shop\Entity\Category;
use xis\Shop\Search\Service\AllProductsSearch;
use xis\Shop\Search\Service\InCategorySearch;

class InCategorySearchTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldHaveCategoryInInitialFilters()
    {
        $category = new Category();
        $service = new InCategorySearch($category);

        $output = $service->getInitialFilters();

        $this->assertTrue(is_array($output));
        $this->assertSame('xis\Shop\Search\Filter\CategoryFilter', get_class($output[0]));
    }
} 