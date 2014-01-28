<?php
namespace xis\ShopCoreBundle\Tests\Repository;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Entity\Product;
use xis\ShopCoreBundle\Repository\DoctrineProductRepository;

class DoctrineProductRepositoryTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function getProductsShouldReturnPager()
    {
        $queryBuilder = $this->prophesize('Doctrine\ORM\QueryBuilder');
        $queryBuilder->select('p')->willReturn($queryBuilder);
        $queryBuilder->from('xisShopCoreBundle:Product', 'p')->willReturn($queryBuilder);
        $queryBuilder->where('p.status=1')->willReturn($queryBuilder);
        $queryBuilder->andWhere('p.quantity>0')->willReturn($queryBuilder);

        $entityManager = $this->prophesize('Doctrine\ORM\EntityManager');
        $entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $pageNum = 20;
        $pager = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\PagerfantaDoctrinePager');
        $pager->getCount()->willReturn(100);
        $pager->setCurrentPage($pageNum)->willReturn($pager);
        $pager->getCurrentPage()->willReturn($pageNum);
        $pager->setLimit(10)->willReturn($pager);

        $pagerFactory = $this->prophesize('xis\ShopCoreBundle\Repository\Pager\PagerFactory');
        $pagerFactory->getPager($queryBuilder)->willReturn($pager);

        $productRepository = new DoctrineProductRepository($entityManager->reveal(), $pagerFactory->reveal());
        $actualPager = $productRepository->getProducts(10, $pageNum);

        $this->assertEquals($pageNum, $actualPager->getCurrentPage());
        $this->assertEquals(100, $actualPager->getCount());
    }

} 