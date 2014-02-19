<?php
namespace xis\Shop\Search\Filter;

use xis\Shop\Entity\Category;
use xis\Shop\Search\Parameter\FilterSet;

class CategoryFilter implements Filter
{
    /** @var Category */
    private $category;

    public function __construct(Category $category)
    {
        $this->category = $category;
    }

    /**
     * @param FilterSet $filter
     * @return null
     */
    function updateFilterSet(FilterSet $filter)
    {
        $filter->setCategory($this->category);
    }

    /**
     * @return string
     */
    function getName()
    {
        return 'category';
    }

    /**
     * @return string
     */
    function getValue()
    {
        return $this->category->getName();
    }
}