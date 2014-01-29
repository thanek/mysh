<?php

namespace xis\ShopCoreBundle\Domain\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 */
class Product
{
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $nameSlug;

    /**
     * @var integer
     */
    private $quantity;

    /**
     * @var string
     */
    private $image;

    /**
     * @var float
     */
    private $price;

    /**
     * @var \DateTime
     */
    private $dateAdded;

    /**
     * @var \DateTime
     */
    private $lastModified;

    /**
     * @var boolean
     */
    private $status;

    /**
     * @var boolean
     */
    private $isPromo;

    /**
     * @var boolean
     */
    private $isAlwaysAvailable;

    /**
     * @var string
     */
    private $signature;


    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return Product
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string 
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set nameSlug
     *
     * @param string $nameSlug
     * @return Product
     */
    public function setNameSlug($nameSlug)
    {
        $this->nameSlug = $nameSlug;

        return $this;
    }

    /**
     * Get nameSlug
     *
     * @return string 
     */
    public function getNameSlug()
    {
        return $this->nameSlug;
    }

    /**
     * Set quantity
     *
     * @param integer $quantity
     * @return Product
     */
    public function setQuantity($quantity)
    {
        $this->quantity = $quantity;

        return $this;
    }

    /**
     * Get quantity
     *
     * @return integer 
     */
    public function getQuantity()
    {
        return $this->quantity;
    }

    /**
     * Set image
     *
     * @param string $image
     * @return Product
     */
    public function setImage($image)
    {
        $this->image = $image;

        return $this;
    }

    /**
     * Get image
     *
     * @return string 
     */
    public function getImage()
    {
        return $this->image;
    }

    /**
     * Set price
     *
     * @param float $price
     * @return Product
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float 
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set dateAdded
     *
     * @param \DateTime $dateAdded
     * @return Product
     */
    public function setDateAdded($dateAdded)
    {
        $this->dateAdded = $dateAdded;

        return $this;
    }

    /**
     * Get dateAdded
     *
     * @return \DateTime 
     */
    public function getDateAdded()
    {
        return $this->dateAdded;
    }

    /**
     * Set lastModified
     *
     * @param \DateTime $lastModified
     * @return Product
     */
    public function setLastModified($lastModified)
    {
        $this->lastModified = $lastModified;

        return $this;
    }

    /**
     * Get lastModified
     *
     * @return \DateTime 
     */
    public function getLastModified()
    {
        return $this->lastModified;
    }

    /**
     * Set status
     *
     * @param boolean $status
     * @return Product
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return boolean 
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set isPromo
     *
     * @param boolean $isPromo
     * @return Product
     */
    public function setIsPromo($isPromo)
    {
        $this->isPromo = $isPromo;

        return $this;
    }

    /**
     * Get isPromo
     *
     * @return boolean 
     */
    public function getIsPromo()
    {
        return $this->isPromo;
    }

    /**
     * Set isAlwaysAvailable
     *
     * @param boolean $isAlwaysAvailable
     * @return Product
     */
    public function setIsAlwaysAvailable($isAlwaysAvailable)
    {
        $this->isAlwaysAvailable = $isAlwaysAvailable;

        return $this;
    }

    /**
     * Get isAlwaysAvailable
     *
     * @return boolean 
     */
    public function getIsAlwaysAvailable()
    {
        return $this->isAlwaysAvailable;
    }

    /**
     * Set signature
     *
     * @param string $signature
     * @return Product
     */
    public function setSignature($signature)
    {
        $this->signature = $signature;

        return $this;
    }

    /**
     * Get signature
     *
     * @return string 
     */
    public function getSignature()
    {
        return $this->signature;
    }
}
