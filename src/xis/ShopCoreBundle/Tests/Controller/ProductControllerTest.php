<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Controller\ProductController;
use xis\ShopCoreBundle\Domain\Entity\Product;

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

        $http = $this->prophesize('xis\ShopCoreBundle\Controller\HttpFacade');
        $http->getRequestParam('page', 1)->willReturn($pageNum);

        $pager = $this->prophesize('PagerfantaDoctrinePager');
        $productRepo = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\DoctrineProductRepository');
        $productRepo->getProducts(60, $pageNum)->willReturn($pager);

        $controller = new ProductController($http->reveal(), $productRepo->reveal());
        $output = $controller->allAction();

        $this->assertEquals($pager->reveal(), $output['pager']);
    }
}