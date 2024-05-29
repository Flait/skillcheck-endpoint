<?php

namespace App\Service;

use App\Client\FakeClient;
use App\Entity\Order;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class OrderService
{

    public function __construct(
        private FakeClient $fakeClient,
        private DenormalizerInterface $serializer)
    {
    }

    public function getOrder(int $id): Order
    {
        $data = $this->fakeClient->getOrderDataById($id);

        $order = $this->serializer->denormalize($data, Order::class);

        if ($order instanceof Order)
        {
            return $order;
        }

        throw new \Exception('Failed to get the order from data.');
    }
}