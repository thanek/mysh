<?php
namespace xis\ShopCoreBundle\Tests\Domain\Entity;

use xis\ShopCoreBundle\Domain\Entity\Category;

class CategoryTest extends AbstractEntityTestCase
{
    public function setup()
    {
        parent::setup();
        $this->entity = new Category();
    }

    public function testSettersAndGetters()
    {
        $this->checkId();
        $this->checkGetterAndSetter('name', 'foo');
        $this->checkGetterAndSetter('slug', 'foo');
        $this->checkGetterAndSetter('sortOrder', 1);
        $this->checkGetterAndSetter('dateAdded', new \DateTime());
        $this->checkGetterAndSetter('lastModified', new \DateTime());
        $this->checkGetterAndSetter('status', true);
        $this->checkGetterAndSetter('lft', 1);
        $this->checkGetterAndSetter('rgt', 1);
        $this->checkGetterAndSetter('level', 1);
    }
}