<?php
namespace xis\Shop\Tests\Search\Service;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTestCase;
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
        $pager = $this->prophesize('xis\Shop\Repository\Pager\Pager');
        $paramsConverter = $this->prophesize('xis\Shop\Search\Parameter\Converter\ParametersConverter');
        $paramsConverter->getFilters()->willReturn(array());

        $productRepository = $this->prophesize('xis\Shop\Repository\ProductRepository');
        $productRepository->search(Argument::any('xis\Shop\Search\Parameter\FilterSet'), 100, 1)->willReturn($pager);

        $service = new AllProductsSearch();
        $output = $service->getResults($paramsConverter->reveal(), $productRepository->reveal(), 100, 1);

        $this->assertSame($output, $pager->reveal());
    }
} 