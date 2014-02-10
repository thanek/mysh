<?php
namespace xis\ShopDoctrineAdapter\Repository;

use Doctrine\ORM\EntityManager;
use xis\Shop\Entity\Category;
use xis\Shop\Repository\CategoryRepository;

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
        $queryBuilder = $this->createQueryBuilder()
            ->where('c.level=1')
            ->addOrderBy('c.sortOrder', 'asc');

        return $queryBuilder->getQuery()->getResult();
    }

    /**
     * @param $id
     * @return Category
     */
    function find($id)
    {
        return $this->createQueryBuilder()
            ->where('c.id=:id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
    }

    /**
     * @return \Doctrine\ORM\QueryBuilder
     */
    protected function createQueryBuilder()
    {
        return $this->entityManager->createQueryBuilder()
            ->select('c')
            ->from('xisShop:Category', 'c');
    }
}