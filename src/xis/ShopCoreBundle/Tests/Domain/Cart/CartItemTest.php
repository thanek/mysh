<?php
namespace xis\ShopCoreBundle\Tests\Domain\Cart;

use xis\ShopCoreBundle\Domain\Cart\CartItem;
use xis\ShopCoreBundle\Tests\Domain\Entity\AbstractEntityTestCase;

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