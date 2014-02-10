<?php
namespace xis\Shop\Cart;

use xis\Shop\Entity\CartItem;
use xis\Shop\Entity\Product;
use xis\Shop\Repository\EntityNotFoundException;
use xis\Shop\Repository\ProductRepository;

class CartService
{
    /** @var CartProvider */
    private $cartProvider;
    /** @var ProductRepository */
    private $productRepository;

    function __construct(CartProvider $cartProvider, ProductRepository $productRepository)
    {
        $this->cartProvider = $cartProvider;
        $this->productRepository = $productRepository;
    }

    /**
     * @param int $productId
     * @throws \xis\Shop\Repository\EntityNotFoundException
     * @return null
     */
    public function addItem($productId)
    {
        $product = $this->findProduct($productId);
        if (!$product) {
            throw new EntityNotFoundException();
        }
        $cartItem = new CartItem();
        $cartItem->setQuantity(1);
        $cartItem->setProductId($productId);
        $cartItem->setPrice($product->getPrice());
        $cartItem->setProductName($product->getName());

        $cart = $this->cartProvider->getOrCreateCart();
        $cart->addItem($cartItem);
        $this->cartProvider->saveCart($cart);
    }

    public function getCart()
    {
        return $this->cartProvider->getOrCreateCart();
    }

    public function disposeCart()
    {
        $this->cartProvider->clear();
    }

    /**
     * @param $productId
     * @return Product
     */
    protected function findProduct($productId)
    {
        return $this->productRepository->find($productId);
    }
} 