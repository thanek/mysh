<?php
namespace xis\Shop\Search\Parameter\Converter;

use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Search\Filter\Filter;

interface ParametersConverter
{
    /**
     * @param CategoryRepository $categoryRepository
     * @return Filter[]
     */
    function getFilters(CategoryRepository $categoryRepository);
}