<?php

use PHPUnit\Framework\TestCase;
use Cart\{Cart, Product, Storable};

use Dotenv\Exception\InvalidFileException;

class CartTest extends TestCase
{
    protected Cart $cart;
    protected Storable $mockStorage;
    protected int $precision;

    public function setUp(): void
    {
        $this->mockStorage = $this->createMock(Storable::class);
        $this->cart = new Cart($this->mockStorage);
        $this->cart->reset();
        $this->precision = $_ENV['PRECISION'];
    }

    /**
     * test add product
     * 
     * test l'ajout d'un produit avec une quantite et un prix. On teste qu'on obtient bien le bon total une fois le produit achete
     * 
     */
    public function testAddOneProduct()
    {
        $apple = new Product(name: 'apple', price: .5);
        $total = round(10 * .5 * 1.2, $this->precision);
        $cart = $this->addProduct($apple, 10, $total);

        $this->assertEquals($cart->total(), $total);
    }

    /**
     * test add multiple products
     *
     * On ajoute de **plusieurs** produits et on verifie qu'on a bien le total (mock)
     */
    public function testTotalProducts()
    {
        $totalApple = round(10 * .5 * 1.2, $this->precision);
        $totalOrange = round(10 * .7 * 1.2, $this->precision);
        $totalBananas = round(10 * .8 * 1.2, $this->precision);
        $products = [
            'apple' => $totalApple,
            'orange' => $totalOrange,
            'bananas' => $totalBananas,
        ];
        $sum = array_sum($products);

        $this->mockStorage->method('getStorage')->willReturn($products);

        $this->assertEquals($this->cart->total(), round($sum, $this->precision));
    }

    public function testReset()
    {
        // $apple = new Product(name: 'apple', price: .6);
        // $cart = $this->addProduct(product: $apple, quantity: 10, total: 6.);

        // $this->assertEquals($cart->total(), 6.);
        $this->mockStorage->expects($this->once())->method('reset');
        $this->cart->reset();
        // $this->assertEquals($cart->total(), 0.);
    }

    /**
     * ajout un produit dans la classe Cart
     * 
     * @param Product $product 
     * @param int $quantity 
     * @param float $total 
     * 
     * @return \Cart Return instance of Cart
     */
    protected function addProduct(Product $product, int $quantity, float $total)
    {
        $this->mockStorage->method('getStorage')->willReturn([
            $product->getName() => $total
        ]);

        $this->cart->buy(product: $product, quantity: $quantity);

        return $this->cart;
    }
}
