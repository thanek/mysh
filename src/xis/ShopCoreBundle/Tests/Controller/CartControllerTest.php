<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\RedirectResponse;
use xis\ShopCoreBundle\Controller\CartController;
use xis\ShopCoreBundle\Controller\HttpFacade;
use xis\ShopCoreBundle\Domain\Cart\CartService;
use xis\ShopCoreBundle\Domain\Entity\Cart;

class CartControllerTest extends ProphecyTestCase
{
    /** @var CartController */
    private $cartController;
    /** @var CartService|ObjectProphecy */
    private $cartService;
    /** @var HttpFacade|ObjectProphecy */
    private $http;

    public function setup()
    {
        parent::setup();

        $this->cartService = $this->prophesize('xis\ShopCoreBundle\Domain\Cart\CartService');
        $this->http = $this->prophesize('xis\ShopCoreBundle\Controller\HttpFacade');

        $this->cartController = new CartController($this->http->reveal(), $this->cartService->reveal());
    }

    /**
     * @test
     */
    public function shouldAddItem()
    {
        $response = $this->expectRedirectResponse('http://blah.bla');
        $this->expectFlashMessage('notice', 'Item added to cart');
        $this->cartService->addItem(123)->shouldBeCalled();

        $output = $this->cartController->addItemAction(123);

        $this->assertEquals($response, $output);
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
        $response = $this->expectRedirectResponse('http://blah.bla');
        $this->expectFlashMessage('notice', 'Cart has been disposed');
        $this->cartService->disposeCart()->shouldBeCalled();

        $output = $this->cartController->disposeAction();

        $this->assertEquals($response, $output);
    }

    protected function expectFlashMessage($type, $message)
    {
        $this->http->addFlashMessage($type, $message)->shouldBeCalled();
    }

    /**
     * @param string $url
     * @param int $status
     * @return RedirectResponse
     */
    protected function expectRedirectResponse($url, $status = 302)
    {
        $response = new RedirectResponse($url, $status);
        $this->http->redirect('products_all')->willReturn($response);
        return $response;
    }
} 