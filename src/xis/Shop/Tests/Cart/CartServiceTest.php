<?php
namespace xis\Shop\Tests\Cart;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\Shop\Cart\CartProvider;
use xis\Shop\Cart\CartService;
use xis\Shop\Entity\Cart;
use xis\Shop\Entity\Product;
use xis\Shop\Repository\EntityNotFoundException;
use xis\Shop\Repository\ProductRepository;

class CartServiceTest extends ProphecyTestCase
{
    /** @var CartService */
    private $cartService;
    /** @var CartProvider|ObjectProphecy */
    private $cartProvider;
    /** @var ProductRepository|ObjectProphecy */
    private $productRepository;

    public function setup()
    {
        parent::setup();
        $this->cartProvider = $this->prophesize('xis\Shop\Cart\CartProvider');
        $this->productRepository = $this->prophesize('xis\Shop\Repository\ProductRepository');
        $this->cartService = new CartService(
            $this->cartProvider->reveal(), $this->productRepository->reveal());

    }

    /**
     * @test
     */
    public function shouldAddItemToCart()
    {
        $this->mockProduct(123, 'foo', 12.34);
        $cart = new Cart();
        $this->cartProvider->getOrCreateCart()->willReturn($cart);
        $this->cartProvider->saveCart($cart)->shouldBeCalled();

        $this->cartService->addItem(123);
        $items = $cart->getItems();
        $this->assertEquals(1, count($items));
        $this->assertEquals('foo', $items[123]->getProductName());
        $this->assertEquals(12.34, $items[123]->getPrice());
        $this->assertEquals(1, $items[123]->getQuantity());
    }

    /**
     * @test
     * @expectedException \xis\Shop\Repository\EntityNotFoundException
     */
    public function shouldThrowExceptionOnNonexistentProduct()
    {
        $cart = new Cart();
        $this->cartProvider->getOrCreateCart()->willReturn($cart);
        $this->productRepository->find(123)->willReturn(null);

        $this->cartService->addItem(123);
    }

    /**
     * @test
     */
    public function shouldReturnCartFromProvider()
    {
        $cart = new Cart();
        $this->cartProvider->getOrCreateCart()->willReturn($cart);

        $actualCart = $this->cartService->getCart();

        $this->assertEquals($cart, $actualCart);
    }

    /**
     * @test
     */
    public function shouldDisposeCartByClearingProvider()
    {
        $this->cartProvider->clear()->shouldBeCalled();

        $this->cartService->disposeCart();
    }

    protected function mockProduct($id, $name, $price)
    {
        $product = new Product();
        $product->setName($name);
        $product->setPrice($price);

        $this->productRepository->find($id)->willReturn($product);
    }
} 