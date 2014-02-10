<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Controller\HttpFacade;
use xis\ShopCoreBundle\Controller\ProductController;
use xis\Shop\Entity\Category;
use xis\Shop\Entity\Product;
use xis\Shop\Repository\CategoryRepository;
use xis\Shop\Repository\ProductRepository;

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

        $this->productRepo = $this->prophesize('xis\Shop\Repository\DoctrineProductRepository');
        $this->categoryRepo = $this->prophesize('xis\Shop\Repository\DoctrineCategoryRepository');
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
        $this->assertEquals('All products', $output['title']);
    }

    /**
     * @test
     */
    public function shouldRetrieveAllProductsPagerFromGivenCategory()
    {
        $pageNum = 1;
        $this->http->getRequestParam('page', 1)->willReturn($pageNum);

        $category = new Category();
        $category->setName('Some category');
        $this->categoryRepo->find(123)->willReturn($category);

        $pager = $this->prophesize('PagerfantaDoctrinePager');
        $this->productRepo->getProductsFromCategory($category, 60, $pageNum)->willReturn($pager);

        $output = $this->controller->browseCategoryAction('foo_bar_baz', 123);

        $this->assertEquals($pager->reveal(), $output['pager']);
        $this->assertEquals('Some category', $output['title']);
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