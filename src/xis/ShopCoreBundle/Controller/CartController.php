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
class CartController extends Controller implements CartAddItemObserver
{
    /** @var CartService */
    private $cartService;
    /** @var ContainerInterface */
    protected $container;

    function __construct(CartService $cartService, ContainerInterface $container)
    {
        $this->cartService = $cartService;
        $this->container = $container;
    }

    /**
     * @Route("/cart/add/{id}",name="cart_add")
     */
    public function addItemAction($id)
    {
        return $this->cartService->addItem($id, $this);
    }

    function itemAdded(CartItem $cartItem)
    {
        $this->get('session')->getFlashBag()->add('notice', 'Item added to cart');
        return $this->redirect($this->generateUrl('products_all'));
    }
}
