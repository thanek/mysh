<?php
namespace xis\Shop\Tests\Cart;

use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Entity\CartItem;
use xis\Shop\Cart\CartProvider;
use xis\Shop\Storage\SessionStorage;
use xis\Shop\Storage\Storage;

class CartProviderTest extends ProphecyTestCase
{
    /** @var CartProvider */
    private $cartProvider;
    /** @var Storage */
    private $storage;

    public function setup()
    {
        parent::setup();
        $this->storage = $this->prophesize('xis\Shop\Storage\Storage');
        $this->cartProvider = new CartProvider($this->storage->reveal());
    }

    /**
     * @test
     */
    public function shouldCreateEmptyCart()
    {
        $cart = $this->cartProvider->getOrCreateCart();

        $this->assertTrue(is_a($cart, 'xis\Shop\Cart\CartInterface'));
        $this->assertEquals(0, count($cart->getItems()));
    }

    /**
     * @test
     */
    public function shouldReturnExistingCart()
    {
        $cartItem = new CartItem();
        $cartItem->setProductId(123);
        $cartItem->setQuantity(1);
        $cart1 = $this->cartProvider->getOrCreateCart();
        $cart1->addItem($cartItem);
        $this->cartProvider->saveCart($cart1);
        $this->storage->get()->willReturn($cart1);

        $cart2 = $this->cartProvider->getOrCreateCart();

        $this->assertEquals($cart1, $cart2);
    }

    /**
     * @test
     */
    public function shouldStoreCart()
    {
        $cart = $this->cartProvider->getOrCreateCart();
        $this->storage->store($cart)->shouldBeCalled();

        $this->cartProvider->saveCart($cart);
    }

    /**
     * @test
     */
    public function shouldClearCart()
    {
        $this->cartProvider->getOrCreateCart();
        $this->storage->clear()->shouldBeCalled();

        $this->cartProvider->clear();
    }
}