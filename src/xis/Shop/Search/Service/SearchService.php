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
        $filterSet = $this->createFilterSet($parametersConverter, $context);

        return $context->getProductRepository()->search($filterSet, $limit, $page);
    }

    /**
     * @param ParametersConverter $parametersConverter
     * @param SearchContext $context
     * @return FilterSet
     */
    protected function createFilterSet(ParametersConverter $parametersConverter, SearchContext $context)
    {
        $initialFilters = $this->getInitialFilters();
        $queryFilters = $parametersConverter->getFilters($context->getCategoryRepository());

        return $context->getFilterSetBuilder()
            ->addFilters($initialFilters)
            ->addFilters($queryFilters)
            ->getFilterSet();
    }

    /**
     * @return Filter[]
     */
    public abstract function getInitialFilters();
}