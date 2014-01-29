<?php
namespace xis\ShopCoreBundle\Domain\Cart;

use xis\ShopCoreBundle\Domain\Cart\CartProvider;

class CartService
{
    /** @var CartProvider */
    private $cartProvider;

    function __construct(CartProvider $cartProvider)
    {
        $this->cartProvider = $cartProvider;
    }

    /**
     * @param int $productId
     * @param CartAddItemObserver $observer
     */
    public function addItem($productId, CartAddItemObserver $observer)
    {
        $cartItem = new CartItem();
        $cartItem->setQuantity(1);
        $cartItem->setProductId($productId);
        $cartItem->setProductName('name');

        $cart = $this->cartProvider->getOrCreateCart();
        $cart->addItem($cartItem);
        $this->cartProvider->saveCart($cart);

        return $observer->itemAdded($cartItem);
    }
} 