<?php
namespace xis\Shop\Tests\Search\Builder;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Builder\SearchBuilder;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;
use xis\Shop\Search\Parameter\FilterSetBuilder;
use xis\Shop\Search\Parameter\Provider\SearchParameterProvider;

class SearchBuilderTest extends ProphecyTestCase
{
    /** @var SearchBuilder */
    private $searchBuilder;
    /** @var ProductRepository | ObjectProphecy */
    private $productRepository;
    /** @var CategoryRepository | ObjectProphecy */
    private $categoryRepository;
    /** @var FilterSetBuilder | ObjectProphecy */
    private $filterSetBuilder;

    public function setup()
    {
        parent::setup();
        $this->productRepository = $this->prophesize('xis\Shop\Repository\ProductRepository');
        $this->categoryRepository = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $this->filterSetBuilder = $this->prophesize('xis\Shop\Search\Parameter\FilterSetBuilder');
        $this->searchBuilder = new SearchBuilder(
            $this->filterSetBuilder->reveal(), $this->productRepository->reveal(), $this->categoryRepository->reveal());
    }

    /**
     * @test
     */
    public function shouldCreateParametersConverterWithGivenProvider()
    {
        $paramsProvider = $this->mockParametersProvider();
        $paramsProvider->getParamsConverter($this->categoryRepository)->shouldBeCalled();

        $output = $this->searchBuilder->with($paramsProvider->reveal());

        $this->assertNotNull($output);
        $this->assertSame($this->searchBuilder, $output);
    }

    /**
     * @test
     */
    public function shouldAcceptSearchService()
    {
        $searchService = $this->mockSearchService();

        $output = $this->searchBuilder->using($searchService->reveal());

        $this->assertNotNull($output);
        $this->assertSame($this->searchBuilder, $output);
    }

    /**
     * @test
     */
    public function shouldGetResults()
    {
        $converter = $this->mockParametersConverter();
        $pager = $this->mockPager();

        $paramsProvider = $this->mockParametersProvider();
        $paramsProvider->getParamsConverter($this->categoryRepository)->willReturn($converter);
        $this->searchBuilder->with($paramsProvider->reveal());
        $searchService = $this->mockSearchService();
        $this->searchBuilder->using($searchService->reveal());
        $searchService
            ->getResults(
                $this->filterSetBuilder->reveal(), $converter->reveal(), $this->productRepository->reveal(), 100, 1)
            ->willReturn($pager);

        $output = $this->searchBuilder->getResults(100, 1);

        $this->assertSame($output, $pager->reveal());
    }

    /**
     * @test
     * @expectedException \xis\Shop\Search\Builder\UninitializedBuilderException
     */
    public function shouldNotSearchWhenNotInitializedAtAll()
    {
        $this->searchBuilder->getResults(100, 1);
    }

    /**
     * @test
     * @expectedException \xis\Shop\Search\Builder\UninitializedBuilderException
     */
    public function shouldNotSearchWhenNoParamsProviderSet()
    {
        $searchService = $this->mockSearchService();
        $this->searchBuilder->using($searchService->reveal());
        $this->searchBuilder->getResults(100, 1);
    }

    /**
     * @test
     * @expectedException \xis\Shop\Search\Builder\UninitializedBuilderException
     */
    public function shouldNotSearchWhenNoSearchServiceSet()
    {
        $paramsConverter = $this->mockParametersConverter();
        $paramsProvider = $this->mockParametersProvider();
        $paramsProvider->getParamsConverter($this->categoryRepository)->willReturn($paramsConverter);

        $this->searchBuilder->with($paramsProvider->reveal());
        $this->searchBuilder->getResults(100, 1);
    }

    /**
     * @return ObjectProphecy|SearchParameterProvider
     */
    protected function mockParametersProvider()
    {
        return $this->prophesize('xis\Shop\Search\Parameter\Provider\SearchParameterProvider');
    }

    /**
     * @return ObjectProphecy|ParametersConverter
     */
    protected function mockParametersConverter()
    {
        return $this->prophesize('xis\Shop\Search\Parameter\Converter\ParametersConverter');
    }

    /**
     * @return ObjectProphecy
     */
    protected function mockSearchService()
    {
        return $this->prophesize('xis\Shop\Search\Service\SearchService');
    }

    /**
     * @return ObjectProphecy
     */
    protected function mockPager()
    {
        return $this->prophesize('xis\Shop\Repository\Pager\Pager');
    }
} 