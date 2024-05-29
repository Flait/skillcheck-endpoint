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
    private FakeClient $fakeClient;
    private DenormalizerInterface $serializer;
    private OrderService $orderService;

    protected function setUp(): void
    {
        $this->fakeClient = $this->createMock(FakeClient::class);
        $this->serializer = $this->createMock(DenormalizerInterface::class);
        $this->orderService = new OrderService($this->fakeClient, $this->serializer);
    }

    public function testGetOrderReturnsOrderInstance(): void
    {
        $orderId = 1;
        $orderData = ['id' => $orderId, 'name' => 'Test Order'];

        $this->fakeClient->expects($this->once()) //@phpstan-ignore method.notFound
            ->method('getOrderDataById')
            ->with($orderId)
            ->willReturn($orderData);

        $order = $this->createMock(Order::class);
        $this->serializer->expects($this->once()) //@phpstan-ignore method.notFound
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

        $this->fakeClient->expects($this->once()) //@phpstan-ignore method.notFound
            ->method('getOrderDataById')
            ->with($orderId)
            ->willReturn($orderData);

        $this->serializer->expects($this->once()) //@phpstan-ignore method.notFound
            ->method('denormalize')
            ->with($orderData, Order::class)
            ->willReturn(null);

        $this->expectException(\Exception::class);
        $this->expectExceptionMessage('Failed to get the order from data.');

        $this->orderService->getOrder($orderId);
    }
}