<?php
namespace xis\Shop\Tests\Entity;

use Prophecy\PhpUnit\ProphecyTestCase;

class AbstractEntityTestCase extends ProphecyTestCase
{
    /** @var  Object */
    protected $entity;

    public function checkId()
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