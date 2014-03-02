<?php
namespace xis\ShopDoctrineAdapter\Tests\Repository;

use Doctrine\ORM\EntityManager;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Entity\Category;
use xis\ShopDoctrineAdapter\Repository\DoctrineCategoryRepository;

class DoctrineCategoryRepositoryTest extends ProphecyTestCase
{
    /** @var CategoryRepository */
    private $categoryRepository;
    /** @var EntityManager|ObjectProphecy */
    private $entityManager;

    public function setup()
    {
        parent::setup();

        $this->entityManager = $this->prophesize('Doctrine\ORM\EntityManager');

        $this->categoryRepository = new DoctrineCategoryRepository(
            $this->entityManager->reveal());
    }

    /**
     * @test
     */
    public function shouldGetMainCategoriesUsingQueryBuilder()
    {
        $mainCategories = array(
            new Category(),
            new Category()
        );
        $query = $this->prophesize('Doctrine\ORM\AbstractQuery');
        $query->getResult()->willReturn($mainCategories);
        $queryBuilder = $this->prophesize('Doctrine\ORM\QueryBuilder');
        $queryBuilder->select('c')->willReturn($queryBuilder);
        $queryBuilder->from('xisShop:Category', 'c')->willReturn($queryBuilder);
        $queryBuilder->where('c.level=1')->willReturn($queryBuilder);
        $queryBuilder->andWhere('c.status=1')->willReturn($queryBuilder);
        $queryBuilder->addOrderBy('c.sortOrder', 'asc')->willReturn($queryBuilder);
        $queryBuilder->getQuery()->willReturn($query);
        $this->entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $actualCategories = $this->categoryRepository->getMainCategories();

        $this->assertEquals($mainCategories, $actualCategories);
    }

    /**
     * @test
     */
    public function shouldFindCategoryById()
    {
        $category = new Category();

        $query = $this->prophesize('Doctrine\ORM\AbstractQuery');
        $query->getSingleResult()->willReturn($category);

        $queryBuilder = $this->createQueryBuilderMock();
        $queryBuilder->where('c.id=:id')->willReturn($queryBuilder);
        $queryBuilder->setParameter('id', 123)->willReturn($queryBuilder);
        $queryBuilder->getQuery()->willReturn($query);
        $this->entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $actualCategory = $this->categoryRepository->find(123);

        $this->assertEquals($category, $actualCategory);
    }

    /**
     * @return \Prophecy\Prophecy\ObjectProphecy
     */
    protected function createQueryBuilderMock()
    {
        $queryBuilder = $this->prophesize('Doctrine\ORM\QueryBuilder');
        $queryBuilder->select('c')->willReturn($queryBuilder);
        $queryBuilder->from('xisShop:Category', 'c')->willReturn($queryBuilder);
        return $queryBuilder;
    }
}