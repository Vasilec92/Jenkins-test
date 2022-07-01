<?php
use PHPUnit\Framework\TestCase;
use Cart\{Cart, Product, Storable};
use Cart\Observers\LogArray;

class CartObserverTest extends TestCase
{
    protected Cart $cart;
    protected Storable $mockStorage;
    protected int $precision;
    protected LogArray $mocklogArray;

    public function setUp(): void
    {
        $this->mockStorage = $this->createMock(Storable::class);
        $this->mocklogArray = $this->createMock(LogArray::class);
        $this->cart = new Cart($this->mockStorage);
        $this->cart->attach($this->mocklogArray);
        $this->cart->reset();
        $this->precision = $_ENV['PRECISION'];
    }

    public function testAmount(){
        $product = new Product(name : 'superApple', price : 5.5);

        $this->mocklogArray->expects($this->once())->method('update');
        $this->cart->buy(product : $product, quantity: 10 );
    }
}
