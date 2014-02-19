<?php
namespace xis\Shop\Tests\Search\Service;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTestCase;
use xis\Shop\Search\Parameter\FilterSet;
use xis\Shop\Search\Service\AllProductsSearch;

class AllProductSearchTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldHaveNoInitialFilters()
    {
        $service = new AllProductsSearch();

        $output = $service->getInitialFilters();

        $this->assertTrue(is_array($output));
        $this->assertEmpty($output);
    }

    /**
     * @test
     */
    public function shouldReturnSearchResultPager()
    {
        $service = new AllProductsSearch();

        $initialFilters = $service->getInitialFilters();
        $queryFilters = array('filter1', 'filter2');
        $filterSet = new FilterSet();

        $context = $this->prophesize('xis\Shop\Search\Service\SearchContext');

        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $context->getCategoryRepository()->willReturn($categoryRepository);

        $filterSetBuilder = $this->prophesize('xis\Shop\Search\Parameter\FilterSetBuilder');
        $filterSetBuilder->addFilters($queryFilters)->willReturn($filterSetBuilder);
        $filterSetBuilder->addFilters($initialFilters)->willReturn($filterSetBuilder);
        $filterSetBuilder->getFilterSet()->willReturn($filterSet);
        $context->getFilterSetBuilder()->willReturn($filterSetBuilder);

        $pager = $this->prophesize('xis\Shop\Repository\Pager\Pager');
        $productRepository = $this->prophesize('xis\Shop\Repository\ProductRepository');
        $productRepository->search($filterSet, 100, 1)->willReturn($pager);
        $context->getProductRepository()->willReturn($productRepository);

        $paramsConverter = $this->prophesize('xis\Shop\Search\Parameter\Converter\ParametersConverter');
        $paramsConverter->getFilters($categoryRepository)->willReturn($queryFilters);


        $output = $service->getResults($paramsConverter->reveal(), $context->reveal(), 100, 1);

        $this->assertSame($output, $pager->reveal());
    }
} 