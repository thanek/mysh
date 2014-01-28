<?php
namespace xis\ShopCoreBundle\Repository\Pager;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;

class DoctrinePagerFactory implements PagerFactory
{
    /**
     * @param $queryBuilder
     * @return Pager
     */
    function getPager($queryBuilder)
    {
        $adapter = new DoctrineORMAdapter($queryBuilder);
        $pagerFanta = new Pagerfanta($adapter);
        return new PagerfantaDoctrinePager($pagerFanta);
    }
}