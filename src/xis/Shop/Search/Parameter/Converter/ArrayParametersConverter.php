<?php
namespace xis\Shop\Search\Parameter\Converter;

use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Search\Filter\CategoryFilter;
use xis\Shop\Search\Filter\Filter;
use xis\Shop\Search\Filter\KeywordFilter;
use xis\Shop\Search\Filter\PriceFromFilter;
use xis\Shop\Search\Filter\PriceToFilter;

class ArrayParametersConverter implements ParametersConverter
{
    /** @var array */
    private $query;

    function __construct(array $query)
    {
        $this->query = $query;
    }

    /**
     * @param CategoryRepository $categoryRepository
     * @return Filter[]
     */
    function getFilters(CategoryRepository $categoryRepository)
    {
        $query = $this->query;
        $ret = array();
        if (isset($query['keyword'])) {
            $ret[] = new KeywordFilter($query['keyword']);
        }
        if (isset($query['price_from'])) {
            $ret[] = new PriceFromFilter($query['price_from']);
        }
        if (isset($query['price_to'])) {
            $ret[] = new PriceToFilter($query['price_to']);
        }
        if (isset($query['category'])) {
            $category = $categoryRepository->find($query['category']);
            $ret[] = new CategoryFilter($category);
        }
        return $ret;
    }
}