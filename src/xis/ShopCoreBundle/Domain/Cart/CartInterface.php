<?php
namespace xis\ShopCoreBundle\Domain\Cart;

interface CartInterface
{
    /**
     * @return CartItemInterface[]
     */
    function getItems();

    /**
     * @param CartItemInterface $cartItem
     * @return null
     */
    function addItem(CartItemInterface $cartItem);

    /**
     * @param $productId
     * @return null
     */
    function removeItem($productId);

    /**
     * @param $productId
     * @return CartItemInterface
     */
    function getItem($productId);

    /**
     * @param CartItemInterface $cartItem
     * @return null
     */
    function modifyItem(CartItemInterface $cartItem);
}