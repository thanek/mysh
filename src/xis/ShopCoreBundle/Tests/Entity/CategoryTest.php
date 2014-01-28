<?php
namespace xis\ShopCoreBundle\Tests\Entity;

use Prophecy\PhpUnit\ProphecyTestCase;
use xis\ShopCoreBundle\Entity\Category;

class CategoryTest extends ProphecyTestCase
{
    /** @var  Category */
    protected $entity;

    public function setup()
    {
        parent::setup();
        $this->entity = new Category();
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

    public function testSlug()
    {
        $v = 'foo';
        $this->entity->setSlug($v);
        $this->assertEquals($v, $this->entity->getSlug());
    }

    public function testSortOrder()
    {
        $v = 1;
        $this->entity->setSortOrder($v);
        $this->assertEquals($v, $this->entity->getSortOrder());
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

    public function testLft()
    {
        $v = 1;
        $this->entity->setLft($v);
        $this->assertEquals($v, $this->entity->getLft());
    }

    public function testRgt()
    {
        $v = 1;
        $this->entity->setRgt($v);
        $this->assertEquals($v, $this->entity->getRgt());
    }

    public function testLevel()
    {
        $v = 1;
        $this->entity->setLevel($v);
        $this->assertEquals($v, $this->entity->getLevel());
    }
}