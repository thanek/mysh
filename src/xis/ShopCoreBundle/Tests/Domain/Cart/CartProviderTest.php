<?php
namespace xis\ShopCoreBundle\Tests\Domain\Cart;

use Prophecy\Argument\Token\AnyValuesToken;
use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Domain\Cart\CartItem;
use xis\ShopCoreBundle\Domain\Cart\CartProvider;
use xis\ShopCoreBundle\Domain\Storage\SessionStorage;
use xis\ShopCoreBundle\Domain\Storage\Storage;

class CartProviderTest extends ProphecyTestCase
{
    /** @var CartProvider */
    private $cartProvider;
    /** @var Storage */
    private $storage;

    public function setup()
    {
        parent::setup();
        $this->storage = $this->prophesize('xis\ShopCoreBundle\Domain\Storage\Storage');
        $this->storage->generateId()->willReturn('abcdef123456');
        $this->cartProvider = new CartProvider($this->storage->reveal());
    }

    /**
     * @test
     */
    public function shouldCreateEmptyCart()
    {
        $cart = $this->cartProvider->getOrCreateCart();

        $this->assertTrue(is_a($cart, 'xis\ShopCoreBundle\Domain\Cart\CartInterface'));
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
        $cart2 = $this->cartProvider->getOrCreateCart();

        $this->assertEquals($cart1, $cart2);
    }

    /**
     * @test
     */
    public function shouldStoreCart()
    {
        $cart = $this->cartProvider->getOrCreateCart();
        $this->storage->store('abcdef123456', $cart)->shouldBeCalled();

        $this->cartProvider->saveCart($cart);
    }

    /**
     * @test
     */
    public function shouldClearCart()
    {
        $this->cartProvider->getOrCreateCart();
        $this->storage->clear('abcdef123456')->shouldBeCalled();

        $this->cartProvider->clear();
    }
}