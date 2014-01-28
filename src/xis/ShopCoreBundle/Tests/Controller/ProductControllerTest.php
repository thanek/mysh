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
    public function allActionShouldRetrieveProductsPager()
    {
        $products = array(
            new Product(),
            new Product()
        );
        $pageNum = 1;

        $pager = $this->prophesize('PagerfantaDoctrinePager');
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $request->get('page', 1)->willReturn($pageNum);
        $productRepo = $this->prophesize('xis\ShopCoreBundle\Repository\DoctrineProductRepository');
        $productRepo->getProducts(60, $pageNum)->willReturn($pager);

        $controller = new ProductController($request->reveal(), $productRepo->reveal());
        $output = $controller->allAction();

        $this->assertEquals($pager->reveal(), $output['pager']);
    }
}