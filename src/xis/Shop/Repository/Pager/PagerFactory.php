<?php
namespace xis\Shop\Repository\Pager;

interface PagerFactory
{
    /**
     * @param $queryBuilder
     * @return Pager
     */
    function getPager($queryBuilder);
} 