<?php
namespace xis\Shop\Search\Parameter;

use xis\Shop\Entity\Category;

class FilterSet
{
    /** @var string */
    private $keyword;
    /** @var Category */
    private $category;
    /** @var double */
    private $priceFrom;
    /** @var double */
    private $priceTo;

    /**
     * @return string
     */
    public function getKeyword()
    {
        return $this->keyword;
    }

    /**
     * @param string $keyword
     * @return FilterSet
     */
    public function setKeyword($keyword)
    {
        $this->keyword = $keyword;
        return $this;
    }

    /**
     * @return \xis\Shop\Entity\Category
     * @return FilterSet
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * @param \xis\Shop\Entity\Category $category
     * @return FilterSet
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * @return double
     */
    public function getPriceFrom()
    {
        return $this->priceFrom;
    }

    /**
     * @param double $priceFrom
     * @return FilterSet
     */
    public function setPriceFrom($priceFrom)
    {
        $this->priceFrom = $priceFrom;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPriceTo()
    {
        return $this->priceTo;
    }

    /**
     * @param double $priceTo
     * @return FilterSet
     */
    public function setPriceTo($priceTo)
    {
        $this->priceTo = $priceTo;
        return $this;
    }
}