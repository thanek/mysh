<?php
namespace xis\Shop\Search\Builder;

use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Filter\Filter;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;
use xis\Shop\Search\Parameter\FilterSetBuilder;
use xis\Shop\Search\Service\SearchContext;
use xis\Shop\Search\Service\SearchService;

class SearchBuilder
{
    /** @var ParametersConverter */
    private $converter;
    /** @var SearchService */
    private $searchService;
    /** @var SearchContext */
    private $context;

    /**
     * @param SearchContext $context
     */
    function __construct(SearchContext $context)
    {
        $this->context = $context;
    }


    /**
     * @param ParametersConverter $converter
     * @return SearchBuilder
     */
    public function with(ParametersConverter $converter)
    {
        $this->converter = $converter;
        return $this;
    }

    /**
     * @param SearchService $searchService
     * @return SearchBuilder
     */
    function using(SearchService $searchService)
    {
        $this->searchService = $searchService;
        return $this;
    }

    /**
     * @param $limit
     * @param int $pageNum
     * @return Pager
     */
    public function getResults($limit, $pageNum = 1)
    {
        return $this->get()->getResults($this->converter, $this->context, $limit, $pageNum);
    }

    /**
     * @return Filter[]
     */
    public function getFilters()
    {
        return $this->get()->getQueryFilters();
    }

    /**
     * @return SearchService
     */
    private function get()
    {
        $this->checkParamsConverter();
        $this->checkSearchService();

        return $this->searchService;
    }

    /**
     * @throws UninitializedBuilderException
     */
    protected function checkParamsConverter()
    {
        if (!$this->converter) {
            throw new UninitializedBuilderException();
        }
    }

    /**
     * @throws UninitializedBuilderException
     */
    protected function checkSearchService()
    {
        if (!$this->searchService) {
            throw new UninitializedBuilderException();
        }
    }
}