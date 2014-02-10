<?php
namespace xis\Shop\Cart;

interface CartItemInterface
{
    /**
     * @param int $productId
     * @return null
     */
    function setProductId($productId);

    /**
     * @return int
     */
    function getProductId();

    /**
     * @param string
     * @return null
     */
    function setProductName($productName);

    /**
     * @return string
     */
    function getProductName();

    /**
     * @param int $quantity
     * @return null
     */
    function setQuantity($quantity);

    /**
     * @return int
     */
    function getQuantity();

    /**
     * @param float $price
     * @return null
     */
    public function setPrice($price);

    /**
     * @return float
     */
    public function getPrice();
}