<?php
namespace xis\ShopCoreBundle\Tests\Controller;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\DependencyInjection\Container;
use xis\ShopCoreBundle\Controller\ProductController;
use xis\ShopCoreBundle\Entity\Product;
use xis\ShopCoreBundle\Repository\DoctrineProductRepository;

class ProductControllerTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function allActionShouldRetrieveAllProducts()
    {
        $products = array(
            new Product(),
            new Product()
        );

        /** @var DoctrineProductRepository | ObjectProphecy $productRepo */
        $productRepo = $this->prophesize('xis\ShopCoreBundle\Repository\DoctrineProductRepository');
        $productRepo->getProducts(10, 0)->willReturn($products);
        /** @var Registry | ObjectProphecy $doctrine */
        $doctrine = $this->prophesize('Doctrine\Bundle\DoctrineBundle\Registry');
        $doctrine->getRepository('xisShopCoreBundle:Product')->willReturn($productRepo);
        /** @var Container | ObjectProphecy $container */
        $container = $this->prophesize('Symfony\Component\DependencyInjection\Container');
        $container->has('doctrine')->willReturn(1);
        $container->get('doctrine')->willReturn($doctrine);

        $controller = new ProductController();
        $controller->setContainer($container->reveal());
        $output = $controller->allAction();

        $this->assertEquals(array('products' => $products), $output);
    }
}