<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\DependencyInjection\ContainerInterface;
use xis\ShopCoreBundle\Controller\CartController;
use xis\ShopCoreBundle\Domain\Cart\CartService;
use xis\ShopCoreBundle\Domain\Entity\Cart;

class CartControllerTest extends ProphecyTestCase
{
    /** @var CartController */
    private $cartController;
    /** @var  CartService|ObjectProphecy */
    private $cartService;
    /** @var ContainerInterface|ObjectProphecy */
    private $container;

    public function setup()
    {
        parent::setup();

        $this->cartService = $this->prophesize('xis\ShopCoreBundle\Domain\Cart\CartService');
        $this->container = $this->prophesize('Symfony\Component\DependencyInjection\ContainerInterface');

        $this->cartController = new CartController($this->cartService->reveal(), $this->container->reveal());
    }

    /**
     * @test
     */
    public function shouldAddItem()
    {
        $this->expectFlashMessage('notice', 'Item added to cart');
        $this->expectGeneratingUrl('products_all', 'http://some.url/products_all');

        $this->cartService->addItem(123)->shouldBeCalled();

        /** @var \Symfony\Component\HttpFoundation\RedirectResponse $output */
        $output = $this->cartController->addItemAction(123);

        $this->assertEquals('Symfony\Component\HttpFoundation\RedirectResponse', get_class($output));
        $this->assertEquals('http://some.url/products_all', $output->getTargetUrl());
    }

    /**
     * @test
     */
    public function shouldGetCartForPreview()
    {
        $cart = new Cart();
        $this->cartService->getCart()->willReturn($cart);

        $output = $this->cartController->previewAction();

        $this->assertEquals(array('cart' => $cart), $output);
    }

    /**
     * @test
     */
    public function shouldDisposeCart()
    {
        $this->expectFlashMessage('notice', 'Cart has been disposed');
        $this->expectGeneratingUrl('products_all', 'http://some.url/blah');
        $this->cartService->disposeCart()->shouldBeCalled();

        $this->cartController->disposeAction();
    }

    protected function expectFlashMessage($type, $message)
    {
        $session = $this->prophesize('Symfony\Component\HttpFoundation\Session\Session');
        $this->container->get('session')->willReturn($session);

        $flashBag = $this->prophesize('Symfony\Component\HttpFoundation\Session\Flash\FlashBag');
        $session->getFlashBag()->willReturn($flashBag);
        $flashBag->add($type, $message)->shouldBeCalled();
    }

    protected function expectGeneratingUrl($route, $outputUrl)
    {
        $router = $this->prophesize('Symfony\Bundle\FrameworkBundle\Routing\Router');
        $this->container->get('router')->willReturn($router);
        $router->generate($route, array(), false)->willReturn($outputUrl);
    }
} 