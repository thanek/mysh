<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\Argument;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\Request;
use xis\Shop\Search\Builder\SearchBuilder;
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
    /** @var SearchBuilder|ObjectProphecy */
    private $searchBuilder;
    /** @var ProductController */
    private $controller;

    public function setup()
    {
        parent::setup();

        $this->http = $this->prophesize('xis\ShopCoreBundle\Controller\HttpFacade');
        $this->productRepo = $this->prophesize('xis\Shop\Repository\ProductRepository');
        $this->categoryRepo = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $this->searchBuilder = $this->prophesize('xis\Shop\Search\Builder\SearchBuilder');

        $this->controller = new ProductController(
            $this->http->reveal(), $this->productRepo->reveal(),
            $this->categoryRepo->reveal(), $this->searchBuilder->reveal());
    }

    /**
     * @test
     */
    public function shouldRetrieveAllProductsPager()
    {
        $pageNum = 1;
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->http->getRequest()->willReturn($request);
        $this->http->getRequestParam('page', 1)->willReturn($pageNum);

        $pager = $this->prophesize('PagerfantaDoctrinePager');
        $this->searchBuilder->with(Argument::any())->willReturn($this->searchBuilder);
        $this->searchBuilder->using(Argument::any())->willReturn($this->searchBuilder);
        $this->searchBuilder->getFilters()->willReturn(array());
        $this->searchBuilder->getResults(60, $pageNum)->willReturn($pager);

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
        $request = $this->prophesize('Symfony\Component\HttpFoundation\Request');
        $this->http->getRequest()->willReturn($request);
        $this->http->getRequestParam('page', 1)->willReturn($pageNum);

        $category = new Category();
        $category->setName('Some category');
        $this->categoryRepo->find(123)->willReturn($category);

        $pager = $this->prophesize('PagerfantaDoctrinePager');
        $this->searchBuilder->with(Argument::any())->willReturn($this->searchBuilder);
        $this->searchBuilder->using(Argument::any())->willReturn($this->searchBuilder);
        $this->searchBuilder->getFilters()->willReturn(array());
        $this->searchBuilder->getResults(60, $pageNum)->willReturn($pager);

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