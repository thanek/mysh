<?php
namespace xis\ShopCoreBundle\Tests\Entity;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Entity\Product;

class ProductTest extends ProphecyTestCase
{
    /** @var  Product */
    protected $entity;

    public function setup()
    {
        parent::setup();
        $this->entity = new Product();
    }

    public function testGetId()
    {
        $this->assertEquals(null, $this->entity->getId());
    }

    public function testName()
    {
        $v = 'foo';
        $this->entity->setName($v);
        $this->assertEquals($v, $this->entity->getName());
    }

    public function testNameSlug()
    {
        $v = 'foo';
        $this->entity->setNameSlug($v);
        $this->assertEquals($v, $this->entity->getNameSlug());
    }

    public function testSignature()
    {
        $v = 'foo';
        $this->entity->setSignature($v);
        $this->assertEquals($v, $this->entity->getSignature());
    }

    public function testQuantity()
    {
        $v = 1;
        $this->entity->setQuantity($v);
        $this->assertEquals($v, $this->entity->getQuantity());
    }

    public function testImage()
    {
        $v = 'foo';
        $this->entity->setImage($v);
        $this->assertEquals($v, $this->entity->getImage());
    }

    public function testPrice()
    {
        $v = 1.20;
        $this->entity->setPrice($v);
        $this->assertEquals($v, $this->entity->getPrice());
    }

    public function testDateAdded()
    {
        $v = new \DateTime();
        $this->entity->setDateAdded($v);
        $this->assertEquals($v, $this->entity->getDateAdded());
    }

    public function testLastModified()
    {
        $v = new \DateTime();
        $this->entity->setLastModified($v);
        $this->assertEquals($v, $this->entity->getLastModified());
    }

    public function testStatus()
    {
        $v = true;
        $this->entity->setStatus($v);
        $this->assertEquals($v, $this->entity->getStatus());
    }

    public function testIsPromo()
    {
        $v = true;
        $this->entity->setIsPromo($v);
        $this->assertEquals($v, $this->entity->getIsPromo());
    }

    public function testIsAlwaysAvailable()
    {
        $v = true;
        $this->entity->setIsAlwaysAvailable($v);
        $this->assertEquals($v, $this->entity->getIsAlwaysAvailable());
    }
}