<?php
namespace xis\Shop\Search\Builder;

use xis\Shop\Entity\Category;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;
use xis\Shop\Search\Parameter\FilterSetBuilder;
use xis\Shop\Search\Service\SearchService;

class SearchBuilder
{
    /** @var ProductRepository */
    private $productRepository;
    /** @var CategoryRepository */
    private $categoryRepository;
    /** @var ParametersConverter */
    private $converter;
    /** @var SearchService */
    private $searchService;
    /** @var FilterSetBuilder */
    private $filterSetBuilder;

    /**
     * @param FilterSetBuilder $filterSetBuilder
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     */
    function __construct(
        FilterSetBuilder $filterSetBuilder, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
        $this->filterSetBuilder = $filterSetBuilder;
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
        $this->checkParamsConverter();
        $this->checkSearchService();

        return $this->searchService->getResults(
            $this->filterSetBuilder, $this->converter, $this->productRepository, $this->categoryRepository, $limit, $pageNum);
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