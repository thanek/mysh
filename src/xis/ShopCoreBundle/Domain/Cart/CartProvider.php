<?php
namespace xis\ShopCoreBundle\Domain\Cart;

use xis\ShopCoreBundle\Domain\Storage\Storage;

class CartProvider
{
    /** @var Storage */
    private $storage;
    private $cart;
    private $id;

    function __construct($storage)
    {
        $this->storage = $storage;
    }

    public function getOrCreateCart()
    {
        if (!$this->cart) {
            $this->cart = new Cart();
            $this->id = $this->storage->generateId();
        }
        return $this->cart;
    }

    public function saveCart(CartInterface $cart)
    {
        $this->storage->store($this->id, $cart);
    }

    public function clear()
    {
        $this->storage->clear($this->id);
    }
} 