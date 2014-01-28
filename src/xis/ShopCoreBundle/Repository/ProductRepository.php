<?php
namespace xis\ShopCoreBundle\Repository;

use xis\ShopCoreBundle\Repository\Pager\Pager;

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