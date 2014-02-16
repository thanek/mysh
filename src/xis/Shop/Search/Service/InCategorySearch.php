<?php
namespace xis\Shop\Search\Service;

use xis\Shop\Entity\Category;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\ProductRepository;
use xis\Shop\Search\Filter\CategoryFilter;
use xis\Shop\Search\Filter\Filter;
use xis\Shop\Search\Parameter\Converter\ParametersConverter;

class InCategorySearch extends SearchService
{
    /** @var Category */
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @return Filter[]
     */
    public function getInitialFilters()
    {
        return array(
            new CategoryFilter($this->category)
        );
    }
}