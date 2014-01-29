<?php
namespace xis\ShopCoreBundle\Domain\Tests\Repository;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Domain\Entity\Product;
use xis\ShopCoreBundle\Domain\Repository\DoctrineProductRepository;

class DoctrineProductRepositoryTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function getProductsShouldReturnPager()
    {
        $queryBuilder = $this->createAllProductsQueryBuilderMock();

        $entityManager = $this->prophesize('Doctrine\ORM\EntityManager');
        $entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $pageNum = 20;
        $pager = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\Pager\PagerfantaPager');
        $pager->getCount()->willReturn(100);
        $pager->setCurrentPage($pageNum)->willReturn($pager);
        $pager->getCurrentPage()->willReturn($pageNum);
        $pager->setLimit(10)->willReturn($pager);

        $pagerFactory = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\Pager\PagerFactory');
        $pagerFactory->getPager($queryBuilder)->willReturn($pager);

        $productRepository = new DoctrineProductRepository($entityManager->reveal(), $pagerFactory->reveal());
        $actualPager = $productRepository->getProducts(10, $pageNum);

        $this->assertEquals($pageNum, $actualPager->getCurrentPage());
        $this->assertEquals(100, $actualPager->getCount());
    }

    /**
     * @test
     */
    public function shouldFindProduct()
    {
        $product = new Product();

        $query = $this->prophesize('Doctrine\ORM\AbstractQuery');
        $query->getSingleResult()->willReturn($product);

        $queryBuilder = $this->createAllProductsQueryBuilderMock();
        $queryBuilder->andWhere('p.id = :id')->willReturn($queryBuilder);
        $queryBuilder->setParameter('id', 123)->willReturn($queryBuilder);
        $queryBuilder->getQuery()->willReturn($query);

        $entityManager = $this->prophesize('Doctrine\ORM\EntityManager');
        $entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $pagerFactory = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\Pager\PagerFactory');
        $productRepository = new DoctrineProductRepository($entityManager->reveal(), $pagerFactory->reveal());

        $actualProduct = $productRepository->find(123);

        $this->assertEquals($product, $actualProduct);
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function createAllProductsQueryBuilderMock()
    {
        $queryBuilder = $this->prophesize('Doctrine\ORM\QueryBuilder');
        $queryBuilder->select('p')->willReturn($queryBuilder);
        $queryBuilder->from('xisShopCoreBundle:Product', 'p')->willReturn($queryBuilder);
        $queryBuilder->where('p.status=1')->willReturn($queryBuilder);
        $queryBuilder->andWhere('p.quantity>0')->willReturn($queryBuilder);
        return $queryBuilder;
    }

} 