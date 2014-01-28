<?php
namespace xis\ShopCoreBundle\Repository;

use xis\ShopCoreBundle\Repository\Pager\Pager;

interface ProductRepository
{
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Pager
     */
    function getProducts($limit, $offset = 0);
}