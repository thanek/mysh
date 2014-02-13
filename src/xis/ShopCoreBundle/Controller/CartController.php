<?php
namespace xis\ShopCoreBundle\Controller;

use xis\Shop\Cart\CartService;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

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
     * @Template()
     */
    public function previewAction()
    {
        $cart = $this->cartService->getCart();
        return array('cart' => $cart);
    }

    public function addItemAction($id)
    {
        $this->cartService->addItem($id);

        $this->http->addFlashMessage('notice', 'Item added to cart');
        return $this->http->redirectToReferer();
    }

    public function disposeAction()
    {
        $this->cartService->disposeCart();

        $this->http->addFlashMessage('notice', 'Cart has been disposed');
        return $this->http->redirectToReferer();
    }
}
