<?php
namespace xis\Shop\Search\Filter;

use xis\Shop\Search\Parameter\FilterSet;

class PriceFromFilter implements Filter
{
    /** @var double */
    private $priceFrom;

    public function __construct($priceFrom)
    {
        $this->priceFrom = $priceFrom;
    }

    /**
     * @param FilterSet $filter
     * @return null
     */
    function updateFilterSet(FilterSet $filter)
    {
        $filter->setPriceFrom($this->priceFrom);
    }
}