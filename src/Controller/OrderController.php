<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

class OrderController extends AbstractController
{
    #[Route('/{Order}', methods: ['GET'])]
    public function getOrder(): JsonResponse
    {
        return $this->json([
            'recommendation' => 'zatim nic moc',
            "status" => "success",
        ]);
    }
}