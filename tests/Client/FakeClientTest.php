<?php

namespace App\Tests\Client;

use App\Client\FakeClient;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\TestCase;
use PHPUnit\Logging\Exception;

#[CoversClass(FakeClient::class)]
final class FakeClientTest extends TestCase
{
    private FakeClient $fakeClient;

    protected function setUp(): void
    {
        $this->fakeClient = new FakeClient();
    }

    public function testGetOrderDataByIdReturnsArray(): void
    {
        $orderData = $this->fakeClient->getOrderDataById(1);
        $this->assertIsArray($orderData);
        $this->assertEquals(1, $orderData['id']);
        $this->assertEquals('Order1', $orderData['name']);
        $this->assertEquals('2023-05-28 14:53:00', $orderData['createdAt']);
        $this->assertEquals(100, $orderData['amount']);
        $this->assertEquals('USD', $orderData['currency']);
        $this->assertEquals('pending', $orderData['status']);
        $this->assertIsArray($orderData['products']);
        $this->assertCount(2, $orderData['products']);
    }

    public function testGetOrderDataByIdThrowsException(): void
    {
        $this->expectException(Exception::class);
        $this->expectExceptionMessage('Order is missing in the datasource');
        $this->fakeClient->getOrderDataById(999);
    }
}