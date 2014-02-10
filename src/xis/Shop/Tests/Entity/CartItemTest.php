<?php
namespace xis\Shop\Tests\Entity;

use xis\Shop\Entity\CartItem;

class CartItemTest extends AbstractEntityTestCase
{
    public function setup()
    {
        parent::setup();
        $this->entity = new CartItem();
    }

    public function testSettersAndGetters()
    {
        $this->checkGetterAndSetter('productId', 123);
        $this->checkGetterAndSetter('productName', 'foo');
        $this->checkGetterAndSetter('quantity', 11);
    }
} 