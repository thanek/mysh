<?php
namespace xis\Shop\Search\Parameter\Converter;

use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Search\Filter\CategoryFilter;
use xis\Shop\Search\Filter\Filter;
use xis\Shop\Search\Filter\KeywordFilter;
use xis\Shop\Search\Filter\PriceFromFilter;
use xis\Shop\Search\Filter\PriceToFilter;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;

class ArrayParametersConverter implements ParametersConverter
{
    /** @var array */
    private $query;
    /** @var CategoryRepository */
    private $categoryRepository;

    function __construct(array $query, CategoryRepository $categoryRepository)
    {
        $this->query = $query;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @return Filter[]
     */
    function getFilters()
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
            $category = $this->categoryRepository->find($query['category']);
            $ret[] = new CategoryFilter($category);
        }
        return $ret;
    }
}