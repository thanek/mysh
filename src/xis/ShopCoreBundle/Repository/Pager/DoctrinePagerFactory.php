<?php
namespace xis\ShopCoreBundle\Repository\Pager;

class DoctrinePagerFactory implements PagerFactory {
    /**
     * @param $queryBuilder
     * @return Pager
     */
    function getPager($queryBuilder)
    {
        return new PagerfantaDoctrinePager($queryBuilder);
    }
}