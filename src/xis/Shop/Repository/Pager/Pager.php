<?php
namespace xis\Shop\Repository\Pager;

interface Pager
{
    /**
     * @param int $limit
     * @return Pager
     */
    function setLimit($limit);

    /**
     * @param $page
     * @return Pager
     */
    function setCurrentPage($page);

    /**
     * @return int
     */
    function getCurrentPage();

    /**
     * @return int
     */
    function getCount();

    /**
     * @return int
     */
    function getPageCount();

    /**
     * @return int
     */
    function getNextPage();

    /**
     * @return int
     */
    function getPreviousPage();

    /**
     * @return array|\Traversable
     */
    function getResults();
} 