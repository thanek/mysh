<?php
namespace xis\Shop\Search\Parameter\Converter;

use xis\Shop\Search\Filter\Filter;

interface ParametersConverter
{
    /**
     * @return Filter[]
     */
    function getFilters();
}