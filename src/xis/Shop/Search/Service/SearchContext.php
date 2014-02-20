<?php
namespace xis\Shop\Search\Service;

use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Parameter\FilterSetBuilder;

class SearchContext
{
    /** @var ProductRepository */
    private $productRepository;
    /** @var CategoryRepository */
    private $categoryRepository;
    /** @var FilterSetBuilder */
    private $filterSetBuilder;

    function __construct(
        FilterSetBuilder $filterSetBuilder, ProductRepository $productRepository, CategoryRepository $categoryRepository)
    {
        $this->filterSetBuilder = $filterSetBuilder;
        $this->productRepository = $productRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \xis\Shop\Repository\ProductRepository
     */
    public function getProductRepository()
    {
        return $this->productRepository;
    }

    /**
     * @return \xis\Shop\Repository\CategoryRepository
     */
    public function getCategoryRepository()
    {
        return $this->categoryRepository;
    }

    /**
     * @return \xis\Shop\Search\Parameter\FilterSetBuilder
     */
    public function getFilterSetBuilder()
    {
        return $this->filterSetBuilder;
    }
} 