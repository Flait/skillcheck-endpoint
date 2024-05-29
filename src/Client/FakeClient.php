<?php

namespace App\Client;

class FakeClient
{
    private const ORDERS = [
        [
            'id' => 1,
            'createdAt' => '2023-05-28 14:53:00',
            'name' => 'Order1',
            'amount' => 100,
            'currency' => 'USD',
            'status' => 'pending',
            'products' => [
                ['id' => 1, 'name' => 'Product1', 'price' => 20],
                ['id' => 2, 'name' => 'Product2', 'price' => 80]
            ]
        ],
        [
            'id' => 2,
            'createdAt' => '2023-05-29 15:00:00',
            'name' => 'Order2',
            'amount' => 150,
            'currency' => 'EUR',
            'status' => 'completed',
            'products' => [
                ['id' => 3, 'name' => 'Product3', 'price' => 150]
            ]
        ],
    ];

    /**
     * @return mixed[]|null
     */
    function getOrderDataById(int $id): ?array
    {
        $index = array_search($id, array_column(self::ORDERS, 'id'));
        return $index !== false ? self::ORDERS[$index] : null;
    }
}