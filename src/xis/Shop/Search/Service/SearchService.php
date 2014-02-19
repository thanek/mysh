<?php
namespace xis\Shop\Search\Service;

use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Filter\Filter;
use xis\Shop\Search\Parameter\FilterSet;
use xis\Shop\Search\Parameter\FilterSetBuilder;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;

abstract class SearchService
{
    /** @var  CategoryRepository */
    private $categoryRepository;

    /**
     * @param FilterSetBuilder $filterSetBuilder
     * @param ParametersConverter $paramsConverter
     * @param ProductRepository $productRepository
     * @param CategoryRepository $categoryRepository
     * @param int $limit
     * @param int $page
     * @return Pager
     */
    public function getResults(
        FilterSetBuilder $filterSetBuilder, ParametersConverter $paramsConverter,
        ProductRepository $productRepository, CategoryRepository $categoryRepository,
        $limit, $page = 1)
    {
        $this->categoryRepository = $categoryRepository;
        $filterSet = $this->createFilterSet($filterSetBuilder, $paramsConverter);

        return $productRepository->search($filterSet, $limit, $page);
    }

    /**
     * @param FilterSetBuilder $filterSetBuilder
     * @param ParametersConverter $parametersConverter
     * @return FilterSet
     */
    protected function createFilterSet(FilterSetBuilder $filterSetBuilder, ParametersConverter $parametersConverter)
    {
        $initialFilters = $this->getInitialFilters();
        $queryFilters = $parametersConverter->getFilters($this->categoryRepository);

        return $filterSetBuilder
            ->addFilters($initialFilters)
            ->addFilters($queryFilters)
            ->getFilterSet();
    }

    /**
     * @return Filter[]
     */
    public abstract function getInitialFilters();
}