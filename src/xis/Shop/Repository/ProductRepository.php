<?php
namespace xis\Shop\Repository;

use xis\Shop\Entity\Category;
use xis\Shop\Entity\Product;
use xis\Shop\Repository\Pager\Pager;

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