<?php
namespace xis\ShopCoreBundle\Domain\Cart;

use xis\ShopCoreBundle\Domain\Cart\CartProvider;
use xis\ShopCoreBundle\Domain\Entity\CartItem;
use xis\ShopCoreBundle\Domain\Entity\Product;
use xis\ShopCoreBundle\Domain\Repository\EntityNotFoundException;
use xis\ShopCoreBundle\Domain\Repository\ProductRepository;

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
     * @throws \xis\ShopCoreBundle\Domain\Repository\EntityNotFoundException
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