<?php

namespace App\Tests\Service;

use App\Client\FakeClient;
use App\Entity\Order;
use App\Service\OrderService;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

#[CoversClass(OrderService::class)]
final class OrderServiceTest extends TestCase
{
    private OrderService $orderService;

    protected function setUp(): void
    {
        $this->orderService = new OrderService($this->fakeClient, $this->serializer);
    }

    public function testGetOrderReturnsOrderInstance(): void
    {
        $orderId = 1;
        $orderData = ['id' => $orderId, 'name' => 'Test Order'];

        $this->createMock(FakeClient::class)->expects($this->once())
            ->method('getOrderDataById')
            ->with($orderId)
            ->willReturn($orderData);

        $order = $this->createMock(Order::class);
        $this->createMock(DenormalizerInterface::class)->expects($this->once())
            ->method('denormalize')
            ->with($orderData, Order::class)
            ->willReturn($order);

        $result = $this->orderService->getOrder($orderId);

        $this->assertInstanceOf(Order::class, $result);
        $this->assertSame($order, $result);
    }

    public function testGetOrderThrowsExceptionWhenDenormalizationFails(): void
    {
        $orderId = 1;
        $orderData = ['id' => $orderId, 'name' => 'Test Order'];

        $this->createMock(FakeClient::class)->expects($this->once())
            ->method('getOrderDataById')
            ->with($orderId)
            ->willReturn($orderData);

        $this->createMock(DenormalizerInterface::class)->expects($this->once())
            ->method('denormalize')
            ->with($orderData, Order::class)
            ->willReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to get the order from data.');

        $this->orderService->getOrder($orderId);
    }
}