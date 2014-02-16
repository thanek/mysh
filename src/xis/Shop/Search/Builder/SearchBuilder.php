<?php
namespace xis\Shop\Search\Builder;

use xis\Shop\Entity\Category;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;
use xis\Shop\Search\Parameter\Provider\SearchParameterProvider;
use xis\Shop\Search\Service\AllProductsSearch;
use xis\Shop\Search\Service\InCategorySearch;
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

    /**
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     */
    function __construct(ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }


    /**
     * @param SearchParameterProvider $provider
     * @return SearchBuilder
     */
    public function with(SearchParameterProvider $provider)
    {
        $this->converter = $provider->getParamsConverter($this->categoryRepository);
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
        return $this->searchService->getResults($this->converter, $this->productRepository, $limit, $pageNum);
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