<?php
namespace xis\ShopCoreBundle\Repository;

use xis\ShopCoreBundle\Entity\Product;

interface ProductRepository
{
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Product[]
     */
    function getProducts($limit, $offset = 0);
} 