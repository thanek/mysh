<?php
namespace xis\Shop\Tests\Search\Builder;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Builder\SearchBuilder;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;
use xis\Shop\Search\Parameter\FilterSetBuilder;
use xis\Shop\Search\Service\SearchContext;
use xis\Shop\Search\Service\SearchService;

class SearchBuilderTest extends ProphecyTestCase
{
    /** @var SearchBuilder */
    private $searchBuilder;
    /** @var SearchContext | ObjectProphecy */
    private $context;

    public function setup()
    {
        parent::setup();
        $this->context = $this->prophesize('xis\Shop\Search\Service\SearchContext');
        $this->searchBuilder = new SearchBuilder($this->context->reveal());
    }

    /**
     * @test
     */
    public function shouldGetResults()
    {
        $pager = $this->mockPager();
        $converter = $this->mockParametersConverter();
        $searchService = $this->mockSearchService();
        $searchService->getResults($converter->reveal(), $this->context->reveal(), 100, 1)
            ->willReturn($pager);

        $output = $this->searchBuilder
            ->with($converter->reveal())
            ->using($searchService->reveal())
            ->getResults(100, 1);

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
    public function shouldNotSearchWhenNoParamsConverterSet()
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

        $this->searchBuilder->with($paramsConverter->reveal());
        $this->searchBuilder->getResults(100, 1);
    }

    /**
     * @return ObjectProphecy | ParametersConverter
     */
    protected function mockParametersConverter()
    {
        return $this->prophesize('xis\Shop\Search\Parameter\Converter\ParametersConverter');
    }

    /**
     * @return ObjectProphecy | SearchService
     */
    protected function mockSearchService()
    {
        return $this->prophesize('xis\Shop\Search\Service\SearchService');
    }

    /**
     * @return ObjectProphecy | Pager
     */
    protected function mockPager()
    {
        return $this->prophesize('xis\Shop\Repository\Pager\Pager');
    }
} 