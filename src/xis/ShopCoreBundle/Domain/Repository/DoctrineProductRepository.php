<?php
namespace xis\ShopCoreBundle\Domain\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Query\Expr\Join;
use Doctrine\ORM\QueryBuilder;
use xis\ShopCoreBundle\Domain\Entity\Category;
use xis\ShopCoreBundle\Domain\Entity\Product;
use xis\ShopCoreBundle\Domain\Repository\Pager\Pager;
use xis\ShopCoreBundle\Domain\Repository\Pager\PagerFactory;

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
            ->from('xisShopCoreBundle:Product', 'p')
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
