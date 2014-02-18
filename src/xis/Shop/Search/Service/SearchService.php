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
    /** @var ParametersConverter */
    private $paramsConverter;
    /** @var ProductRepository */
    private $productRepository;

    /**
     * @param FilterSetBuilder $filterSetBuilder
     * @param ParametersConverter $paramsConverter
     * @param ProductRepository $repository
     * @param int $limit
     * @param int $page
     * @return Pager
     */
    public function getResults(
        FilterSetBuilder $filterSetBuilder, ParametersConverter $paramsConverter,
        ProductRepository $repository, $limit, $page = 1)
    {
        $filterSet = $this->createFilterSet($filterSetBuilder, $paramsConverter);

        return $repository->search($filterSet, $limit, $page);
    }

    /**
     * @param FilterSetBuilder $filterSetBuilder
     * @param ParametersConverter $parametersConverter
     * @return FilterSet
     */
    protected function createFilterSet(FilterSetBuilder $filterSetBuilder, ParametersConverter $parametersConverter)
    {
        $initialFilters = $this->getInitialFilters();
        $queryFilters = $parametersConverter->getFilters();

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