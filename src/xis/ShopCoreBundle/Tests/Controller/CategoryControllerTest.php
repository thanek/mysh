<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Doctrine\Bundle\DoctrineBundle\Registry;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\DependencyInjection\Container;
use xis\ShopCoreBundle\Controller\CategoryController;
use xis\ShopCoreBundle\Entity\Category;
use xis\ShopCoreBundle\Repository\DoctrineCategoryRepository;

class CategoryControllerTest extends ProphecyTestCase
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

        /** @var DoctrineCategoryRepository | ObjectProphecy $categoryRepo */
        $categoryRepo = $this->prophesize('xis\ShopCoreBundle\Repository\DoctrineCategoryRepository');
        $categoryRepo->getMainCategories()->willReturn($categories);
        /** @var Registry | ObjectProphecy $doctrine */
        $doctrine = $this->prophesize('Doctrine\Bundle\DoctrineBundle\Registry');
        $doctrine->getRepository('xisShopCoreBundle:Category')->willReturn($categoryRepo);
        /** @var Container | ObjectProphecy $container */
        $container = $this->prophesize('Symfony\Component\DependencyInjection\Container');
        $container->has('doctrine')->willReturn(1);
        $container->get('doctrine')->willReturn($doctrine);

        $controller = new CategoryController();
        $controller->setContainer($container->reveal());
        $output = $controller->mainCategoriesAction();

        $this->assertEquals(array('categories' => $categories), $output);
    }
} 