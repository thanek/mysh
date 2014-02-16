<?php
namespace xis\Shop\Search\Filter;

use xis\Shop\Search\Parameter\FilterSet;

class PriceToFilter implements Filter
{
    /** @var double */
    private $priceTo;

    function __construct($priceTo)
    {
        $this->priceTo = $priceTo;
    }

    /**
     * @param FilterSet $filter
     * @return null
     */
    function updateFilterSet(FilterSet $filter)
    {
        $filter->setPriceTo($this->priceTo);
    }
}