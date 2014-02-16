<?php
namespace xis\Shop\Search\Parameter\Provider;

use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Search\Parameter\Converter\ArrayParametersConverter;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;

class ArrayParametrizedSearch implements SearchParameterProvider
{
    private $array;

    /**
     * @param array $array
     */
    public function __construct(array $array)
    {
        $this->array = $array;
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return ParametersConverter
     */
    public function getParamsConverter(CategoryRepository $categoryRepository)
    {
        return new ArrayParametersConverter($this->array, $categoryRepository);
    }
}