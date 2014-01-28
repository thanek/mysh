<?php
namespace xis\ShopCoreBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use xis\ShopCoreBundle\Entity\Category;

class DoctrineCategoryRepository implements CategoryRepository
{
    /** @var EntityManager */
    private $entityManager;

    /**
     * @param EntityManager $entityManager
     */
    function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * @return Category[]
     */
    function getMainCategories()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from('xisShopCoreBundle:Category', 'c')
            ->where('c.level=1')
            ->addOrderBy('c.sortOrder','asc');

        return $queryBuilder->getQuery()->getResult();
    }
}