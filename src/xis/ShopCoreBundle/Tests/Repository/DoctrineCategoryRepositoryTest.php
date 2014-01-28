<?php
namespace xis\ShopCoreBundle\Tests\Repository;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Entity\Category;
use xis\ShopCoreBundle\Repository\DoctrineCategoryRepository;

class DoctrineCategoryRepositoryTest extends ProphecyTestCase
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

        /** @var \Doctrine\ORM\Mapping\ClassMetadata | ObjectProphecy $metaData */
        $metaData = $this->prophesize('\Doctrine\ORM\Mapping\ClassMetadata');
        /** @var \Doctrine\ORM\EntityManager | ObjectProphecy $em */
        $em = $this->prophesize('\Doctrine\ORM\EntityManager');
        /** @var \Doctrine\ORM\UnitOfWork | ObjectProphecy $unitOfWork */
        $unitOfWork = $this->prophesize('\Doctrine\ORM\UnitOfWork');
        /** @var \Doctrine\ORM\Persisters\BasicEntityPersister | ObjectProphecy $persister */
        $persister = $this->prophesize('\Doctrine\ORM\Persisters\BasicEntityPersister');

        $metaData->name = 'someClass';
        $em->getUnitOfWork()->willReturn($unitOfWork);
        $unitOfWork->getEntityPersister('someClass')->willReturn($persister);
        $persister->loadAll(array('level' => 1), array('sortOrder' => 'asc'), null, null)
            ->willReturn($mainCategories);

        $categoryRepository = new DoctrineCategoryRepository($em->reveal(), $metaData->reveal());
        $actualCategories = $categoryRepository->getMainCategories();

        $this->assertEquals($mainCategories, $actualCategories);

    }
} 