<?php
namespace xis\ShopCoreBundle\Tests\Controller;


use Doctrine\Bundle\DoctrineBundle\Registry;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\DependencyInjection\Container;
use xis\ShopCoreBundle\Controller\ProductController;
use xis\ShopCoreBundle\Entity\Product;
use xis\ShopCoreBundle\Repository\DoctrineProductRepository;

class ProductControllerTest extends AbstractControllerTestCase
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

        $productRepo = $this->getRepoMock(
            'xis\ShopCoreBundle\Repository\DoctrineProductRepository',
            'xisShopCoreBundle:Product');
        $productRepo->getProducts(10, 0)->willReturn($products);

        $controller = new ProductController();
        $controller->setContainer($this->container->reveal());
        $output = $controller->allAction();

        $this->assertEquals(array('products' => $products), $output);
    }
}