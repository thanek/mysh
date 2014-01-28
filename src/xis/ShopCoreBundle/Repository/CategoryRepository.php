<?php
namespace xis\ShopCoreBundle\Repository;

interface CategoryRepository
{
    /**
     * @return Category[]
     */
    function getMainCategories();
}
