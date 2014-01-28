<?php
namespace xis\ShopCoreBundle\Repository;

use Doctrine\ORM\EntityRepository;
use xis\ShopCoreBundle\Entity\Category;

class DoctrineCategoryRepository extends EntityRepository implements CategoryRepository
{
    /**
     * @return Category[]
     */
    function getMainCategories()
    {
        return $this->findBy(array('level' => 1), array('sortOrder' => 'asc'));
    }
}