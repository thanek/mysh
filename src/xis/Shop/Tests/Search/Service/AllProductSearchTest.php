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

        $categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $pager = $this->prophesize('xis\Shop\Repository\Pager\Pager');
        $paramsConverter = $this->prophesize('xis\Shop\Search\Parameter\Converter\ParametersConverter');
        $paramsConverter->getFilters($categoryRepository)->willReturn($queryFilters);

        $filterSetBuilder = $this->prophesize('xis\Shop\Search\Parameter\FilterSetBuilder');
        $filterSetBuilder->addFilters($queryFilters)->willReturn($filterSetBuilder);
        $filterSetBuilder->addFilters($initialFilters)->willReturn($filterSetBuilder);
        $filterSetBuilder->getFilterSet()->willReturn($filterSet);

        $productRepository = $this->prophesize('xis\Shop\Repository\ProductRepository');
        $productRepository->search($filterSet, 100, 1)->willReturn($pager);

        $output = $service->getResults(
            $filterSetBuilder->reveal(), $paramsConverter->reveal(),
            $productRepository->reveal(), $categoryRepository->reveal(), 100, 1);

        $this->assertSame($output, $pager->reveal());
    }
} 