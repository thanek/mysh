<?php
namespace xis\ShopCoreBundle\Domain\Tests\Repository;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Domain\Entity\Category;
use xis\ShopCoreBundle\Domain\Repository\DoctrineCategoryRepository;

class DoctrineCategoryRepositoryTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function getMainCategoriesShouldGetResultsUsingQueryBuilder()
    {
        $mainCategories = array(
            new Category(),
            new Category()
        );

        $query = $this->prophesize('Doctrine\ORM\AbstractQuery');
        $query->getResult()->willReturn($mainCategories);

        $queryBuilder = $this->prophesize('Doctrine\ORM\QueryBuilder');
        $queryBuilder->select('c')->willReturn($queryBuilder);
        $queryBuilder->from('xisShopCoreBundle:Category', 'c')->willReturn($queryBuilder);
        $queryBuilder->where('c.level=1')->willReturn($queryBuilder);
        $queryBuilder->addOrderBy('c.sortOrder','asc')->willReturn($queryBuilder);
        $queryBuilder->getQuery()->willReturn($query);

        $entityManager = $this->prophesize('Doctrine\ORM\EntityManager');
        $entityManager->createQueryBuilder()->willReturn($queryBuilder);

        $categoryRepository = new DoctrineCategoryRepository($entityManager->reveal());
        $actualCategories = $categoryRepository->getMainCategories();

        $this->assertEquals($mainCategories, $actualCategories);
    }
} 