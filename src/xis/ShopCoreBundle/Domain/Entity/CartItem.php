<?php
namespace xis\ShopCoreBundle\Domain\Entity;

use xis\ShopCoreBundle\Domain\Cart\CartItemInterface;

class CartItem implements CartItemInterface
{
    /** @var int */
    private $productId;
    /** @var string */
    private $productName;
    /** @var int */
    private $quantity;
    /** @var price */
    private $price;

    /**
     * @param int $productId
     * @return null|void
     */
    public function setProductId($productId)
    {
        $this->productId = $productId;
    }

    /**
     * @return int
     */
    public function getProductId()
    {
        return $this->productId;
    }

    /**
     * @param string $productName
     * @return null|void
     */
    public function setProductName($productName)
    {
        $this->productName = $productName;
    }

    /**
     * @return string
     */
    public function getProductName()
    {
        return $this->productName;
    }

    /**
     * @param int $quantity
     * @return null|void
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;
    }

    /**
     * @return int
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * @param float $price
     * @return null
     */
    public function setPrice($price)
    {
        $this->price = $price;
    }

    /**
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }
}