<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\DependencyInjection\Container;
use xis\ShopCoreBundle\Controller\CategoryController;
use xis\ShopCoreBundle\Entity\Category;
use xis\ShopCoreBundle\Repository\DoctrineCategoryRepository;

class CategoryControllerTest extends AbstractControllerTestCase
{
    /**
     * @test
     */
    public function mainCategoriesActionShouldRetrieveCategoriesFromRepo()
    {
        $categories = array(
            new Category(),
            new Category()
        );

        $categoryRepo = $this->getRepoMock(
            'xis\ShopCoreBundle\Repository\DoctrineCategoryRepository',
            'xisShopCoreBundle:Category');
        $categoryRepo->getMainCategories()->willReturn($categories);

        $controller = new CategoryController();
        $controller->setContainer($this->container->reveal());
        $output = $controller->mainCategoriesAction();

        $this->assertEquals(array('categories' => $categories), $output);
    }
} 