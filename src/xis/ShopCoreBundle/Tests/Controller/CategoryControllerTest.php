<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Controller\CategoryController;
use xis\Shop\Entity\Category;

class CategoryControllerTest extends ProphecyTestCase
{
    /**
     * @test
     */
    public function shouldRetrieveMainCategoriesFromRepo()
    {
        $categories = array(
            new Category(),
            new Category()
        );

        $categoryRepo = $this->prophesize('xis\Shop\Repository\CategoryRepository');
        $categoryRepo->getMainCategories()->willReturn($categories);

        $controller = new CategoryController($categoryRepo->reveal());
        $output = $controller->mainCategoriesAction();

        $this->assertEquals(array('categories' => $categories), $output);
    }
} 