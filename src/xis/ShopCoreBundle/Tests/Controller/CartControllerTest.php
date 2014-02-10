<?php
namespace xis\ShopCoreBundle\Tests\Controller;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use Symfony\Component\HttpFoundation\RedirectResponse;
use xis\ShopCoreBundle\Controller\CartController;
use xis\ShopCoreBundle\Controller\HttpFacade;
use xis\Shop\Cart\CartService;
use xis\Shop\Entity\Cart;

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

        $this->cartService = $this->prophesize('xis\Shop\Cart\CartService');
        $this->http = $this->prophesize('xis\ShopCoreBundle\Controller\HttpFacade');

        $this->cartController = new CartController($this->http->reveal(), $this->cartService->reveal());
    }

    /**
     * @test
     */
    public function shouldAddItem()
    {
        $this->cartService->addItem(123)->shouldBeCalled();
        $this->expectFlashMessage('notice', 'Item added to cart');
        $response = $this->expectRedirectToReferer();

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
        $this->cartService->disposeCart()->shouldBeCalled();
        $this->expectFlashMessage('notice', 'Cart has been disposed');
        $response = $this->expectRedirectToReferer();

        $output = $this->cartController->disposeAction();

        $this->assertEquals($response, $output);
    }

    protected function expectFlashMessage($type, $message)
    {
        $this->http->addFlashMessage($type, $message)->shouldBeCalled();
    }

    /**
     * @param int $status
     * @return RedirectResponse
     */
    protected function expectRedirectToReferer($status=302)
    {
        $this->http->getReferer()->willReturn('http://blah.bla');
        $response = new RedirectResponse('http://blah.bla', $status);
        $this->http->redirectToReferer()->willReturn($response);
        return $response;
    }
}