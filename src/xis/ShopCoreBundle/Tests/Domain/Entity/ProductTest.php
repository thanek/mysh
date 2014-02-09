<?php
namespace xis\ShopCoreBundle\Tests\Domain\Entity;

use xis\ShopCoreBundle\Domain\Entity\Category;
use xis\ShopCoreBundle\Domain\Entity\Product;

class ProductTest extends AbstractEntityTestCase
{
    public function setup()
    {
        parent::setup();
        $this->entity = new Product();
    }

    public function testSettersAndGetters()
    {
        $this->checkId();
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
        $this->checkGetterAndSetter('category', new Category());
    }
}