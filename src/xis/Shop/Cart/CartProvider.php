<?php
namespace xis\Shop\Cart;

use xis\Shop\Entity\Cart;
use xis\Shop\Storage\Storage;

class CartProvider
{
    /** @var Storage */
    private $storage;

    function __construct($storage)
    {
        $this->storage = $storage;
    }

    public function getOrCreateCart()
    {
        $cart = $this->storage->get();
        if (!$cart) {
            $cart = new Cart();
            $this->saveCart($cart);
        }
        return $cart;
    }

    public function saveCart(CartInterface $cart)
    {
        $this->storage->store($cart);
    }

    public function clear()
    {
        $this->storage->clear();
    }
} 