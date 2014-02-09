<?php
namespace xis\ShopCoreBundle\Domain\Tests\Repository;

use Doctrine\ORM\QueryBuilder;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Domain\Entity\Category;
use xis\ShopCoreBundle\Domain\Entity\Product;
use xis\ShopCoreBundle\Domain\Repository\DoctrineProductRepository;
use xis\ShopCoreBundle\Domain\Repository\ProductRepository;

class DoctrineProductRepositoryTest extends ProphecyTestCase
{
    /** @var  DoctrineProductRepository */
    private $productRepository;
    /** @var $entityManager |ObjectProphecy */
    private $entityManager;
    /** @var $pagerFactory |PagerFactory */
    private $pagerFactory;

    public function setup()
    {
        parent::setup();

        $this->entityManager = $this->prophesize('Doctrine\ORM\EntityManager');
        $this->pagerFactory = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\Pager\PagerFactory');

        $this->productRepository = new DoctrineProductRepository(
            $this->entityManager->reveal(), $this->pagerFactory->reveal());
    }

    /**
     * @test
     */
    public function shouldReturnAllProductsPager()
    {
        $queryBuilder = $this->createAllProductsQueryBuilderMock();
        $this->entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $pageNum = 20;
        $pager = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\Pager\PagerfantaPager');
        $pager->getCount()->willReturn(100);
        $pager->setCurrentPage($pageNum)->willReturn($pager);
        $pager->getCurrentPage()->willReturn($pageNum);
        $pager->setLimit(10)->willReturn($pager);
        $this->pagerFactory->getPager($queryBuilder)->willReturn($pager);

        $actualPager = $this->productRepository->getProducts(10, $pageNum);

        $this->assertEquals($pageNum, $actualPager->getCurrentPage());
        $this->assertEquals(100, $actualPager->getCount());
    }

    /**
     * @test
     */
    public function shouldReturnAllProductsPagerForGivenCategory()
    {
        $category = new Category();
        $category->setLft(234);
        $category->setRgt(345);

        $queryBuilder = $this->createAllProductsQueryBuilderMock();
        $queryBuilder->join('p.category', 'c')->willReturn($queryBuilder);
        $queryBuilder->andWhere('c.lft>=:lft')->willReturn($queryBuilder);
        $queryBuilder->andWhere('c.rgt<=:rgt')->willReturn($queryBuilder);
        $queryBuilder->setParameter('lft', 234)->willReturn($queryBuilder);
        $queryBuilder->setParameter('rgt', 345)->willReturn($queryBuilder);
        $this->entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $pageNum = 20;
        $pager = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\Pager\PagerfantaPager');
        $pager->getCount()->willReturn(100);
        $pager->setCurrentPage($pageNum)->willReturn($pager);
        $pager->getCurrentPage()->willReturn($pageNum);
        $pager->setLimit(10)->willReturn($pager);
        $this->pagerFactory->getPager($queryBuilder)->willReturn($pager);

        $actualPager = $this->productRepository->getProductsFromCategory($category, 10, $pageNum);

        $this->assertEquals($pageNum, $actualPager->getCurrentPage());
        $this->assertEquals(100, $actualPager->getCount());
    }

    /**
     * @test
     */
    public function shouldFindProductById()
    {
        $product = new Product();

        $query = $this->prophesize('Doctrine\ORM\AbstractQuery');
        $query->getSingleResult()->willReturn($product);

        $queryBuilder = $this->createAllProductsQueryBuilderMock();
        $queryBuilder->andWhere('p.id = :id')->willReturn($queryBuilder);
        $queryBuilder->setParameter('id', 123)->willReturn($queryBuilder);
        $queryBuilder->getQuery()->willReturn($query);
        $this->entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $actualProduct = $this->productRepository->find(123);

        $this->assertEquals($product, $actualProduct);
    }

    /**
     * @return QueryBuilder|ObjectProphecy
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