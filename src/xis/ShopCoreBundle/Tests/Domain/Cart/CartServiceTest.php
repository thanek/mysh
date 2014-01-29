<?php
namespace xis\ShopCoreBundle\Tests\Domain\Cart;

use Prophecy\PhpUnit\ProphecyTestCase;
use Prophecy\Prophecy\ObjectProphecy;
use xis\ShopCoreBundle\Domain\Cart\CartProvider;
use xis\ShopCoreBundle\Domain\Cart\CartService;
use xis\ShopCoreBundle\Domain\Entity\Cart;
use xis\ShopCoreBundle\Domain\Entity\Product;
use xis\ShopCoreBundle\Domain\Repository\EntityNotFoundException;
use xis\ShopCoreBundle\Domain\Repository\ProductRepository;

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
        $this->cartProvider = $this->prophesize('xis\ShopCoreBundle\Domain\Cart\CartProvider');
        $this->productRepository = $this->prophesize('xis\ShopCoreBundle\Domain\Repository\ProductRepository');
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
     * @expectedException \xis\ShopCoreBundle\Domain\Repository\EntityNotFoundException
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
        $cart = new Cart();
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