<?php
namespace xis\ShopCoreBundle\Tests\Domain\Entity;

use Prophecy\PhpUnit\ProphecyTestCase;

class AbstractEntityTestCase extends ProphecyTestCase
{
    /** @var  Object */
    protected $entity;

    public function testGetId()
    {
        $this->assertEquals(null, $this->entity->getId());
    }

    protected function checkGetterAndSetter($fieldName, $value)
    {
        $setterName = 'set' . ucfirst($fieldName);
        $getterName = 'get' . ucfirst($fieldName);

        $this->entity->$setterName($value);

        $this->assertEquals($value, $this->entity->$getterName());
    }
} 