<?php
namespace xis\ShopCoreBundle\Tests\Repository;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Entity\Product;
use xis\ShopCoreBundle\Repository\DoctrineProductRepository;

class DoctrineProductRepositoryTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function getProductsShouldInvokePersister()
    {
        $products = array(
            new Product(),
            new Product()
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
        $persister->loadAll(array(), null, 10, 0)->willReturn($products);

        $productRepository = new DoctrineProductRepository($em->reveal(), $metaData->reveal());
        $actualProducts = $productRepository->getProducts(10, 0);

        $this->assertEquals($products, $actualProducts);
    }

} 