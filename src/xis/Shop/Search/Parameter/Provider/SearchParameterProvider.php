<?php
namespace xis\Shop\Search\Parameter\Provider;

use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;

interface SearchParameterProvider
{
    /**
     * @param CategoryRepository $categoryRepository
     * @return ParametersConverter
     */
    public function getParamsConverter(CategoryRepository $categoryRepository);
}