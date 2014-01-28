<?php
namespace xis\ShopCoreBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use xis\ShopCoreBundle\Repository\Pager\Pager;
use xis\ShopCoreBundle\Repository\Pager\PagerFactory;
use xis\ShopCoreBundle\Repository\Pager\PagerfantaDoctrinePager;

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
     * @param int $offset
     *
     * @return Pager
     */
    function getProducts($limit, $offset = 0)
    {
        $queryBuilder = $this->getAllProductsQueryBuilder();
        $pager = $this->pagerFactory->getPager($queryBuilder);
        $pager->setCurrentPage($offset)->setLimit($limit);
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
}
