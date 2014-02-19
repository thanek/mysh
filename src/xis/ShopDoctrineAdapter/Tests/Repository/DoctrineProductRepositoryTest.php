<?php
namespace xis\ShopDoctrineAdapter\Tests\Repository;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\QueryBuilder;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Entity\Category;
use xis\Shop\Entity\Product;
use xis\Shop\Repository\Pager\Pager;
use xis\Shop\Search\Parameter\FilterSet;
use xis\ShopDoctrineAdapter\Repository\DoctrineProductRepository;

class DoctrineProductRepositoryTest extends ProphecyTestCase
{
    /** @var  DoctrineProductRepository */
    private $productRepository;
    /** @var EntityManager |ObjectProphecy */
    private $entityManager;
    /** @var $pagerFactory |PagerFactory */
    private $pagerFactory;

    public function setup()
    {
        parent::setup();

        $this->entityManager = $this->prophesize('Doctrine\ORM\EntityManager');
        $this->pagerFactory = $this->prophesize('xis\Shop\Repository\Pager\PagerFactory');

        $this->productRepository = new DoctrineProductRepository(
            $this->entityManager->reveal(), $this->pagerFactory->reveal());
    }

    /**
     * @test
     */
    public function shouldReturnAllProductsPager()
    {
        $queryBuilder = $this->mockAllProductsQueryBuilder();

        $pageNum = 20;
        $allResultsCount = 100;
        $limit = 10;
        $this->mockPager($allResultsCount, $pageNum, $limit, $queryBuilder);

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

        $queryBuilder = $this->mockAllProductsQueryBuilder();
        $queryBuilder->join('p.category', 'c')->willReturn($queryBuilder);
        $queryBuilder->andWhere('c.lft>=:lft')->willReturn($queryBuilder);
        $queryBuilder->andWhere('c.rgt<=:rgt')->willReturn($queryBuilder);
        $queryBuilder->setParameter('lft', 234)->willReturn($queryBuilder);
        $queryBuilder->setParameter('rgt', 345)->willReturn($queryBuilder);

        $pageNum = 20;
        $allResultsCount = 100;
        $limit = 10;
        $this->mockPager($allResultsCount, $pageNum, $limit, $queryBuilder);

        $actualPager = $this->productRepository->getProductsFromCategory($category, $limit, $pageNum);

        $this->assertEquals($pageNum, $actualPager->getCurrentPage());
        $this->assertEquals($allResultsCount, $actualPager->getCount());
    }

    /**
     * @test
     */
    public function shouldFindProductById()
    {
        $product = new Product();

        $query = $this->prophesize('Doctrine\ORM\AbstractQuery');
        $query->getSingleResult()->willReturn($product);

        $queryBuilder = $this->mockAllProductsQueryBuilder();
        $queryBuilder->andWhere('p.id=:id')->willReturn($queryBuilder);
        $queryBuilder->setParameter('id', 123)->willReturn($queryBuilder);
        $queryBuilder->getQuery()->willReturn($query);

        $actualProduct = $this->productRepository->find(123);

        $this->assertEquals($product, $actualProduct);
    }

    /**
     * @test
     */
    public function shouldSearchWithGivenFilters()
    {
        $queryBuilder = $this->mockAllProductsQueryBuilder();
        $queryBuilder->andWhere('p.price>=:priceFrom')->willReturn($queryBuilder);
        $queryBuilder->setParameter('priceFrom', 3)->willReturn($queryBuilder);

        $pageNum = 20;
        $allResultsCount = 100;
        $limit = 10;
        $this->mockPager($allResultsCount, $pageNum, $limit, $queryBuilder);
        $filterSet = new FilterSet();
        $filterSet->setPriceFrom(3);

        $result = $this->productRepository->search($filterSet, $limit, $pageNum);

        $this->assertEquals($pageNum, $result->getCurrentPage());
        $this->assertEquals($allResultsCount, $result->getCount());
    }

    /**
     * @test
     */
    public function shouldUseSearchQueryBuilderWhenSearching()
    {
        $category = new Category();
        $category->setLft(123);
        $category->setRgt(234);
        $pageNum = 20;
        $allResultsCount = 100;
        $limit = 10;

        $queryBuilder = $this->mockAllProductsQueryBuilder();
        $queryBuilder->andWhere('p.price>=:priceFrom')->willReturn($queryBuilder);
        $queryBuilder->setParameter('priceFrom', 3)->willReturn($queryBuilder);
        $queryBuilder->andWhere('p.price<=:priceTo')->willReturn($queryBuilder);
        $queryBuilder->setParameter('priceTo', 10)->willReturn($queryBuilder);
        $queryBuilder->join('p.category', 'c')->willReturn($queryBuilder);
        $queryBuilder->andWhere('c.lft>=:lft')->willReturn($queryBuilder);
        $queryBuilder->andWhere('c.rgt<=:rgt')->willReturn($queryBuilder);
        $queryBuilder->setParameter('lft', 123)->willReturn($queryBuilder);
        $queryBuilder->setParameter('rgt', 234)->willReturn($queryBuilder);
        $queryBuilder->andWhere('p.name=:keyword')->willReturn($queryBuilder);
        $queryBuilder->setParameter('keyword', 'foo')->willReturn($queryBuilder);

        $this->mockPager($allResultsCount, $pageNum, $limit, $queryBuilder);
        $filterSet = new FilterSet();
        $filterSet
            ->setPriceFrom(3)
            ->setPriceTo(10)
            ->setKeyword('foo')
            ->setCategory($category);

        $this->productRepository->search($filterSet, $limit, $pageNum);
    }

    /**
     * @return QueryBuilder|ObjectProphecy
     */
    protected function mockAllProductsQueryBuilder()
    {
        $queryBuilder = $this->prophesize('Doctrine\ORM\QueryBuilder');
        $queryBuilder->select('p')->willReturn($queryBuilder);
        $queryBuilder->from('xisShop:Product', 'p')->willReturn($queryBuilder);
        $queryBuilder->where('p.status=1')->willReturn($queryBuilder);
        $queryBuilder->andWhere('p.quantity>0')->willReturn($queryBuilder);
        $this->entityManager->createQueryBuilder()->willReturn($queryBuilder);
        return $queryBuilder;
    }

    /**
     * @param int $allResultsCount
     * @param int $pageNum
     * @param int $limit
     * @param QueryBuilder $queryBuilder
     */
    protected function mockPager($allResultsCount, $pageNum, $limit, $queryBuilder)
    {
        /** @var Pager | ObjectProphecy $pager */
        $pager = $this->prophesize('xis\Shop\Repository\Pager\Pager');
        $pager->getCount()->willReturn($allResultsCount);
        $pager->setCurrentPage($pageNum)->willReturn($pager);
        $pager->getCurrentPage()->willReturn($pageNum);
        $pager->setLimit($limit)->willReturn($pager);
        $this->pagerFactory->getPager($queryBuilder)->willReturn($pager);
    }

}