<?php
namespace xis\Shop\Search\Parameter;

use xis\Shop\Search\Filter\Filter;

class FilterSetBuilder
{
    /** @var FilterSet */
    private $filterSet;

    public function __construct()
    {
        $this->filterSet = new FilterSet();
    }

    /**
     * @param Filter $parameter
     * @return FilterSetBuilder
     */
    public function addFilter(Filter $parameter)
    {
        $parameter->updateFilterSet($this->filterSet);
        return $this;
    }

    /**
     * @param Filter[] $parameters
     * @return FilterSetBuilder
     */
    public function addFilters(array $parameters)
    {
        foreach ($parameters as $parameter) {
            $this->addFilter($parameter);
        }
        return $this;
    }

    /**
     * @return FilterSet
     */
    public function getFilterSet()
    {
        return $this->filterSet;
    }
} 