<?php
namespace xis\ShopDoctrineAdapter\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use xis\Shop\Entity\Category;
use xis\Shop\Entity\Product;
use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Repository\Pager\PagerFactory;
use xis\Shop\Repository\ProductRepository;

class DoctrineProductRepository implements ProductRepository
{
    /** @var  EntityManager */
    private $entityManager;
    /** @var PagerFactory */
    private $pagerFactory;

    function __construct(EntityManager $entityManager, PagerFactory $pagerFactory)
    {
        $this->entityManager = $entityManager;
        $this->pagerFactory = $pagerFactory;
    }

    /**
     * @param int $limit
     * @param int $page
     *
     * @return Pager
     */
    function getProducts($limit, $page = 0)
    {
        $queryBuilder = $this->getAllProductsQueryBuilder();
        $pager = $this->createPager($queryBuilder, $limit, $page);
        return $pager;
    }

    /**
     * @return QueryBuilder
     */
    protected function getAllProductsQueryBuilder()
    {
        $queryBuilder = $this->entityManager->createQueryBuilder()
            ->select('p')
            ->from('xisShop:Product', 'p')
            ->where('p.status=1')
            ->andWhere('p.quantity>0');
        return $queryBuilder;
    }

    /**
     * @param $id
     * @return Product
     */
    function find($id)
    {
        $ret = $this->getAllProductsQueryBuilder()
            ->andWhere('p.id = :id')
            ->setParameter('id', $id)
            ->getQuery()
            ->getSingleResult();
        return $ret;
    }

    /**
     * @param Category $category
     * @param int $limit
     * @param int $page
     * @return Pager
     */
    function getProductsFromCategory(Category $category, $limit, $page = 0)
    {
        $queryBuilder = $this->getAllProductsQueryBuilder()
            ->join('p.category', 'c')
            ->andWhere('c.lft>=:lft')
            ->andWhere('c.rgt<=:rgt')
            ->setParameter('lft', $category->getLft())
            ->setParameter('rgt', $category->getRgt());

        $pager = $this->createPager($queryBuilder, $limit, $page);
        return $pager;
    }

    /**
     * @param $queryBuilder
     * @param $limit
     * @param $page
     * @return Pager
     */
    protected function createPager($queryBuilder, $limit, $page)
    {
        $pager = $this->pagerFactory->getPager($queryBuilder);
        $pager->setCurrentPage($page)->setLimit($limit);
        return $pager;
    }
}
