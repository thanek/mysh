<?php
namespace xis\Shop\Search\Service;

use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Search\Filter\Filter;
use xis\Shop\Search\Parameter\FilterSet;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;

abstract class SearchService
{
    /** @var SearchContext */
    private $context;
    /** @var ParametersConverter */
    private $parametersConverter;

    /**
     * @param ParametersConverter $parametersConverter
     * @param SearchContext $context
     * @param $limit
     * @param int $page
     * @return Pager
     */
    public function getResults(ParametersConverter $parametersConverter, SearchContext $context, $limit, $page = 1)
    {
        $this->context = $context;
        $this->parametersConverter = $parametersConverter;

        $filterSet = $this->createFilterSet();

        return $context->getProductRepository()->search($filterSet, $limit, $page);
    }

    /**
     * @return FilterSet
     */
    protected function createFilterSet()
    {
        $initialFilters = $this->getInitialFilters();
        $queryFilters = $this->getQueryFilters();

        return $this->context->getFilterSetBuilder()
            ->addFilters($initialFilters)
            ->addFilters($queryFilters)
            ->getFilterSet();
    }

    /**
     * @return Filter[]
     */
    public function getQueryFilters()
    {
        return $this->parametersConverter->getFilters($this->context->getCategoryRepository());
    }

    /**
     * @return Filter[]
     */
    public abstract function getInitialFilters();
}