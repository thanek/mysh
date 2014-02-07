<?php
namespace xis\ShopCoreBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use xis\ShopCoreBundle\Domain\Cart\CartAddItemObserver;
use xis\ShopCoreBundle\Domain\Cart\CartItem;
use xis\ShopCoreBundle\Domain\Cart\CartProvider;
use xis\ShopCoreBundle\Domain\Cart\CartService;

/**
 * @Route(service="xis.shop.controller.cart")
 */
class CartController
{
    /** @var CartService */
    private $cartService;
    /** @var HttpFacade */
    protected $http;

    function __construct(HttpFacade $http, CartService $cartService)
    {
        $this->http = $http;
        $this->cartService = $cartService;
    }

    /**
     * @Route("/cart/add/{id}",name="cart_add")
     */
    public function addItemAction($id)
    {
        $this->cartService->addItem($id);

        $this->http->addFlashMessage('notice', 'Item added to cart');
        return $this->http->redirect('products_all');
    }

    /**
     * @Template()
     */
    public function previewAction()
    {
        $cart = $this->cartService->getCart();
        return array('cart' => $cart);
    }

    /**
     * @Route("/cart/dispose",name="cart_dispose")
     */
    public function disposeAction()
    {
        $this->cartService->disposeCart();

        $this->http->addFlashMessage('notice', 'Cart has been disposed');
        return $this->http->redirect('products_all');
    }
}
