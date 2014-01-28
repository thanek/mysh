<?php
namespace xis\ShopCoreBundle\Repository\Pager;

interface PagerFactory
{
    /**
     * @param $queryBuilder
     * @return Pager
     */
    function getPager($queryBuilder);
} 