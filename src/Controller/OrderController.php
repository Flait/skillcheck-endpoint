<?php

namespace App\Controller;

use App\Service\OrderService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
class OrderController extends AbstractController
{
    public function __construct(private OrderService $orderService) {

    }
    #[Route('/{id}', methods: ['GET'])]
    public function getOrder(int $id): JsonResponse
    {
        try {
            $order = $this->orderService->getOrder($id);
        } catch (\Exception) {
            return $this->json(['error' => 'Invalid order ID'], Response::HTTP_BAD_REQUEST);
        }

        return $this->json([
            'order' => $order->toArray(),
            "status" => "success",
        ]);
    }
}