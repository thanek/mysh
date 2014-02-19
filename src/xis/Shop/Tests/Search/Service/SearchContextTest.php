<?php
namespace xis\Shop\Tests\Search\Service;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\Shop\Search\Service\SearchContext;


class SearchContextTest extends ProphecyTestCase
{
    public function testGettersAndSetters()
    {
        $filterSetBuilder = $this->prophesize('xis\Shop\Search\Parameter\FilterSetBuilder');
        $productRepository = $this->prophesize('xis\Shop\Repository\ProductRepository');
        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');

        $context = new SearchContext(
            $filterSetBuilder->reveal(),
            $productRepository->reveal(),
            $categoryRepository->reveal());

        $this->assertSame($context->getFilterSetBuilder(), $filterSetBuilder->reveal());
        $this->assertSame($context->getCategoryRepository(), $categoryRepository->reveal());
        $this->assertSame($context->getProductRepository(), $productRepository->reveal());
    }
} 