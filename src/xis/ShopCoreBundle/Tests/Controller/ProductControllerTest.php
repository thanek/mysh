<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Controller\HttpFacade;
use xis\ShopCoreBundle\Controller\ProductController;
use xis\ShopCoreBundle\Domain\Entity\Category;
use xis\ShopCoreBundle\Domain\Entity\Product;
use xis\ShopCoreBundle\Domain\Repository\CategoryRepository;
use xis\ShopCoreBundle\Domain\Repository\ProductRepository;

class ProductControllerTest extends ProphecyTestCase
{
    /** @var ProductRepository|ObjectProphecy */
    private $productRepo;
    /** @var CategoryRepository|ObjectProphecy */
    private $categoryRepo;
    /** @var  HttpFacade|ObjectProphecy */
    private $http;
    /** @var ProductController */
    private $controller;

    public function setup()
    {
        parent::setup();

        $this->productRepo = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\DoctrineProductRepository');
        $this->categoryRepo = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\DoctrineCategoryRepository');
        $this->http = $this->prophesize('xis\ShopCoreBundle\Controller\HttpFacade');

        $this->controller = new ProductController(
            $this->http->reveal(), $this->productRepo->reveal(), $this->categoryRepo->reveal());
    }

    /**
     * @test
     */
    public function shouldRetrieveAllProductsPager()
    {
        $pageNum = 1;
        $this->http->getRequestParam('page', 1)->willReturn($pageNum);

        $pager = $this->prophesize('PagerfantaDoctrinePager');
        $this->productRepo->getProducts(60, $pageNum)->willReturn($pager);

        $output = $this->controller->allAction();

        $this->assertEquals($pager->reveal(), $output['pager']);
    }

    /**
     * @test
     */
    public function shouldRetrieveAllProductsPagerFromGivenCategory()
    {
        $pageNum = 1;
        $this->http->getRequestParam('page', 1)->willReturn($pageNum);

        $category = new Category();
        $this->categoryRepo->find(123)->willReturn($category);

        $pager = $this->prophesize('PagerfantaDoctrinePager');
        $this->productRepo->getProductsFromCategory($category, 60, $pageNum)->willReturn($pager);

        $output = $this->controller->browseCategoryAction('foo_bar_baz', 123);

        $this->assertEquals($pager->reveal(), $output['pager']);
    }

    /**
     * @test
     */
    public function shouldRedirectToHomepageWhenBrowsingUnknownCategory()
    {
        $this->http->getRequestParam('page', 1)->willReturn(1);
        $this->categoryRepo->find(123)->willReturn(null);
        $this->http->addFlashMessage('notice', 'No such category')->shouldBeCalled();
        $this->http->redirect('home')->shouldBeCalled();

        $this->controller->browseCategoryAction('foo_bar_blah', 123);
    }
}