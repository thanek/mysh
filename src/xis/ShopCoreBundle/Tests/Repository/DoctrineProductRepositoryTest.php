<?php
namespace xis\ShopCoreBundle\Tests\Repository;

use xis\ShopCoreBundle\Entity\Product;
use xis\ShopCoreBundle\Repository\DoctrineProductRepository;

class DoctrineProductRepositoryTest extends AbstractRepositoryTestCase
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

        $this->persister->loadAll(array(), null, 10, 0)->willReturn($products);

        $productRepository = new DoctrineProductRepository($this->em->reveal(), $this->metaData->reveal());
        $actualProducts = $productRepository->getProducts(10, 0);

        $this->assertEquals($products, $actualProducts);
    }

} 