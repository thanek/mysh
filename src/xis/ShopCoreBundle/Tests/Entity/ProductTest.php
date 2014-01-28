<?php
namespace xis\ShopCoreBundle\Tests\Entity;

use xis\ShopCoreBundle\Entity\Product;

class ProductTest extends AbstractEntityTestCase
{
    public function setup()
    {
        parent::setup();
        $this->entity = new Product();
    }

    public function testSettersAndGetters()
    {
        $this->checkGetterAndSetter('name', 'foo');
        $this->checkGetterAndSetter('nameSlug', 'foo');
        $this->checkGetterAndSetter('signature', 'foo');
        $this->checkGetterAndSetter('quantity', 'foo');
        $this->checkGetterAndSetter('image', 'foo');
        $this->checkGetterAndSetter('price', 1.23);
        $this->checkGetterAndSetter('dateAdded', new \DateTime());
        $this->checkGetterAndSetter('lastModified', new \DateTime());
        $this->checkGetterAndSetter('status', true);
        $this->checkGetterAndSetter('isPromo', true);
        $this->checkGetterAndSetter('isAlwaysAvailable', true);
    }
}