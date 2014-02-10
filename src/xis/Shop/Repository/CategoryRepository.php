<?php
namespace xis\Shop\Repository;

use xis\Shop\Entity\Category;

interface CategoryRepository
{
    /**
     * @return Category[]
     */
    function getMainCategories();

    /**
     * @param $id
     * @return Category
     */
    function find($id);
}
