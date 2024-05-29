<?php
namespace App\Tests\Controller;

use App\Client\FakeClient;
use App\Controller\OrderController;
use App\Entity\Order;
use App\Entity\Product;
use App\Serializer\OrderDenormalizer;
use App\Service\OrderService;
use PHPUnit\Framework\Attributes\CoversClass;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

#[CoversClass(OrderController::class)]
#[CoversClass(FakeClient::class)]
#[CoversClass(Order::class)]
#[CoversClass(Product::class)]
#[CoversClass(OrderDenormalizer::class)]
#[CoversClass(OrderService::class)]
final class OrderControllerTest extends WebTestCase
{
    public function testSuccessfulGetOrder(): void
    {
        $client = static::createClient();

        $client->request('GET', '/1');

        $this->assertResponseIsSuccessful();
        $this->assertEquals(
            '{"order":{"id":1,"createdAt":"2023-05-28T14:53:00+00:00","name":"Order1","amount":100,"currency":"USD","status":"pending","products":[{"id":1,"name":"Product1","price":20},{"id":2,"name":"Product2","price":80}]},"status":"success"}',
            $client->getResponse()->getContent()
        );
    }

    public function testInvalidOrderId(): void
    {
        $client = static::createClient();

        $orderService = $this->createMock(OrderService::class);
        $orderService->method('getOrder')
            ->will($this->throwException(new \Exception()));

        self::getContainer()->set(OrderService::class, $orderService);

        $client->request('GET', '/999');

        $this->assertEquals('{"error":"Invalid order ID"}', $client->getResponse()->getContent());
        $this->assertEquals(400, $client->getResponse()->getStatusCode());
    }
}