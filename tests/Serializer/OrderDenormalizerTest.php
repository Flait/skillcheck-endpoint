<?php

namespace App\Tests\Serializer;

use App\Entity\Order;
use App\Entity\Product;
use App\Serializer\OrderDenormalizer;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Exception\UnexpectedValueException;

#[CoversClass(OrderDenormalizer::class)]
#[CoversClass(Order::class)]
#[CoversClass(Product::class)]
final class OrderDenormalizerTest extends TestCase
{
    private OrderDenormalizer $denormalizer;

    protected function setUp(): void
    {
        $this->denormalizer = new OrderDenormalizer();
    }

    public function testSupportsDenormalization(): void
    {
        $this->assertTrue($this->denormalizer->supportsDenormalization([], Order::class));
        $this->assertFalse($this->denormalizer->supportsDenormalization([], Product::class));
    }

    public function testDenormalize(): void
    {
        $data = [
            'id' => 1,
            'createdAt' => '2024-05-29T12:34:56+00:00',
            'name' => 'Test Order',
            'amount' => 100.0,
            'currency' => 'USD',
            'status' => 'pending',
            'products' => [
                [
                    'id' => 1,
                    'name' => 'Product 1',
                    'price' => 50.0,
                ],
                [
                    'id' => 2,
                    'name' => 'Product 2',
                    'price' => 50.0,
                ],
            ],
        ];

        /** @var Order $order */
        $order = $this->denormalizer->denormalize($data, Order::class);

        $this->assertInstanceOf(Order::class, $order);
        $this->assertEquals(1, $order->id);
        $this->assertEquals('Test Order', $order->getName());
        $this->assertEquals(100.0, $order->getAmount());
        $this->assertEquals('USD', $order->getCurrency());
        $this->assertEquals('pending', $order->getStatus());
        $this->assertCount(2, $order->getProducts());
        $this->assertEquals('2024-05-29T12:34:56+00:00', $order->getCreatedAt()->format('c'));

        $product1 = $order->getProducts()[0];
        $this->assertInstanceOf(Product::class, $product1);
        $this->assertEquals(1, $product1->id);
        $this->assertEquals('Product 1', $product1->name);
        $this->assertEquals(50.0, $product1->price);

        $product2 = $order->getProducts()[1];
        $this->assertInstanceOf(Product::class, $product2);
        $this->assertEquals(2, $product2->id);
        $this->assertEquals('Product 2', $product2->name);
        $this->assertEquals(50.0, $product2->price);
    }

    public function testDenormalizeThrowsExceptionForInvalidData(): void
    {
        $this->expectException(UnexpectedValueException::class);
        $this->expectExceptionMessage('The data should be an array.');

        $this->denormalizer->denormalize('invalid data', Order::class);
    }
}