<?php
namespace xis\ShopCoreBundle\Domain\Cart;

interface CartAddItemObserver
{
    function itemAdded(CartItem $cartItem);
} 