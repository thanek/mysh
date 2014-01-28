<?php
namespace xis\ShopCoreBundle\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;
use xis\ShopCoreBundle\Entity\Product;

class DoctrineProductRepository extends EntityRepository implements ProductRepository
{
    /**
     * @param int $limit
     * @param int $offset
     *
     * @return Product[]
     */
    function getProducts($limit, $offset = 0)
    {
        return $this->findBy(array(), null, $limit, $offset);
    }
}
