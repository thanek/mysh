<?php
namespace xis\ShopCoreBundle\Domain\Repository;

use xis\ShopCoreBundle\Domain\Repository\Pager\Pager;

interface ProductRepository
{
    /**
     * @param int $limit
     * @param int $page
     *
     * @return Pager
     */
    function getProducts($limit, $page = 0);
}