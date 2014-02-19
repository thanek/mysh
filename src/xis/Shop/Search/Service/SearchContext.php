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

    /**
     * @return \xis\Shop\Repository\ProductRepository
     */
    public function getProductRepository()
    {
        return $this->productRepository;
    }

    /**
     * @param \xis\Shop\Repository\ProductRepository $productRepository
     */
    public function setProductRepository($productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @return \xis\Shop\Repository\CategoryRepository
     */
    public function getCategoryRepository()
    {
        return $this->categoryRepository;
    }

    /**
     * @param \xis\Shop\Repository\CategoryRepository $categoryRepository
     */
    public function setCategoryRepository($categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return \xis\Shop\Search\Parameter\FilterSetBuilder
     */
    public function getFilterSetBuilder()
    {
        return $this->filterSetBuilder;
    }

    /**
     * @param \xis\Shop\Search\Parameter\FilterSetBuilder $filterSetBuilder
     */
    public function setFilterSetBuilder($filterSetBuilder)
    {
        $this->filterSetBuilder = $filterSetBuilder;
    }
} 