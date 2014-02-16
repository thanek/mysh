<?php
namespace xis\Shop\Search\Filter;

use xis\Shop\Search\Parameter\FilterSet;

interface Filter
{
    /**
     * @param FilterSet $filter
     * @return null
     */
    function updateFilterSet(FilterSet $filter);
} 