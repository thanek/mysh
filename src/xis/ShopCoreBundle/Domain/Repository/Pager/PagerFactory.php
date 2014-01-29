<?php
namespace xis\ShopCoreBundle\Domain\Repository\Pager;

interface PagerFactory
{
    /**
     * @param $queryBuilder
     * @return Pager
     */
    function getPager($queryBuilder);
} 