<?php
namespace xis\ShopCoreBundle\Repository;

use xis\ShopCoreBundle\Entity\Category;

interface CategoryRepository
{
    /**
     * @return Category[]
     */
    function getMainCategories();
}
