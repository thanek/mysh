<?php
namespace xis\ShopDoctrineAdapter\Repository\Pager;

use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Repository\Pager\PagerFactory;
use xis\ShopCoreBundle\Repository\Pager\PagerfantaPager;

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
        return new PagerfantaPager($pagerFanta);
    }
}