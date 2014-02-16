<?php
namespace xis\Shop\Search\Service;

use xis\Shop\Search\Filter\Filter;

class AllProductsSearch extends SearchService
{
    /**
     * @return Filter[]
     */
    public function getInitialFilters()
    {
        return array();
    }
}