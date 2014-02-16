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
     * @param ParametersConverter $paramsConverter
     * @param ProductRepository $repository
     * @param int $limit
     * @param int $page
     * @return Pager
     */
    public function getResults(ParametersConverter $paramsConverter, ProductRepository $repository, $limit, $page = 1)
    {
        $filterSet = $this->createFilterSet($paramsConverter);
        return $repository->search($filterSet, $limit, $page);
    }

    /**
     * @param ParametersConverter $parametersConverter
     * @return FilterSet
     */
    protected function createFilterSet(ParametersConverter $parametersConverter)
    {
        $initialFilters = $this->getInitialFilters();
        $queryFilters = $parametersConverter->getFilters();

        return $this->buildFilterSet($initialFilters, $queryFilters);
    }

    /**
     * @return Filter[]
     */
    public abstract function getInitialFilters();

    /**
     * @param $initialFilters
     * @param $queryFilters
     * @return FilterSet
     */
    protected function buildFilterSet($initialFilters, $queryFilters)
    {
        $filterQueryBuilder = new FilterSetBuilder();

        return $filterQueryBuilder
            ->addFilters($initialFilters)
            ->addFilters($queryFilters)
            ->getFilterSet();
    }
}