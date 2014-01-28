<?php
namespace xis\ShopCoreBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use xis\ShopCoreBundle\Entity\Product;
use xis\ShopCoreBundle\Repository\Pager\Pager;
use xis\ShopCoreBundle\Repository\Pager\PagerfantaDoctrinePager;

class DoctrineProductRepository extends EntityRepository implements ProductRepository
{
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Pager
     */
    function getProducts($limit, $offset = 0)
    {
        $queryBuilder = $this->getEntityManager()->createQueryBuilder()
            ->select('p')
            ->from('xisShopCoreBundle:Product', 'p')
            ->where('p.status=1')
            ->andWhere('p.quantity>0');
        $pager = new PagerfantaDoctrinePager($queryBuilder);
        $pager->setCurrentPage($offset)->setLimit($limit);
        return $pager;
    }
}
