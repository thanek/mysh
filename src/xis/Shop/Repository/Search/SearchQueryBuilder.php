<?php
namespace xis\Shop\Repository\Search;

use xis\Shop\Search\Filter\ProductFilter;
use xis\Shop\Search\Parameter\FilterSet;

abstract class SearchQueryBuilder
{
    public function updateQueryBuilder(FilterSet $query)
    {
        $this->addCategoryFilter($query);
        $this->addPriceFromFilter($query);
        $this->addPriceToFilter($query);
        $this->addKeywordFilter($query);
    }

    protected abstract function addCategoryFilter(FilterSet $query);

    protected abstract function addPriceFromFilter(FilterSet $query);

    protected abstract function addPriceToFilter(FilterSet $query);

    protected abstract function addKeywordFilter(FilterSet $query);
}