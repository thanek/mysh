<?php
namespace xis\ShopCoreBundle\Domain\Repository;

use xis\ShopCoreBundle\Domain\Entity\Category;
use xis\ShopCoreBundle\Domain\Entity\Product;
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

    /**
     * @param Category $category
     * @param int $limit
     * @param int $page
     *
     * @return Pager
     */
    function getProductsFromCategory(Category $category, $limit, $page = 0);

    /**
     * @param $id
     * @return Product
     */
    function find($id);
}