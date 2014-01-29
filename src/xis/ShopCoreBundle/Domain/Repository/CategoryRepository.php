<?php
namespace xis\ShopCoreBundle\Domain\Repository;

use xis\ShopCoreBundle\Domain\Entity\Category;

interface CategoryRepository
{
    /**
     * @return Category[]
     */
    function getMainCategories();
}
