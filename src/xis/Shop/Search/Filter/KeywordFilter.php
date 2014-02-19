<?php
namespace xis\Shop\Search\Filter;

use xis\Shop\Search\Parameter\FilterSet;

class KeywordFilter implements Filter
{
    /** @var string */
    private $keyword;

    public function __construct($keyword)
    {
        $this->keyword = $keyword;
    }

    /**
     * @param FilterSet $filter
     * @return null
     */
    function updateFilterSet(FilterSet $filter)
    {
        $filter->setKeyword($this->keyword);
    }

    /**
     * @return string
     */
    function getName()
    {
        return 'keyword';
    }

    /**
     * @return string
     */
    function getValue()
    {
        return $this->keyword;
    }
}