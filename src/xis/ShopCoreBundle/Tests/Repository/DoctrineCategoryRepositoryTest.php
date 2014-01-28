<?php
namespace xis\ShopCoreBundle\Tests\Repository;

use xis\ShopCoreBundle\Entity\Category;
use xis\ShopCoreBundle\Repository\DoctrineCategoryRepository;

class DoctrineCategoryRepositoryTest extends AbstractRepositoryTestCase
{
    /**
     * @test
     */
    public function getMainCategoriesShouldInvokePersister()
    {
        $mainCategories = array(
            new Category(),
            new Category()
        );

        $this->persister->loadAll(array('level' => 1), array('sortOrder' => 'asc'), null, null)
            ->willReturn($mainCategories);

        $categoryRepository = new DoctrineCategoryRepository($this->em->reveal(), $this->metaData->reveal());
        $actualCategories = $categoryRepository->getMainCategories();

        $this->assertEquals($mainCategories, $actualCategories);

    }
} 