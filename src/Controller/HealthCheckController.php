<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    #[Route('/api/healthcheck', name: 'health_check', methods: ['GET'])]
    public function healthCheck(): JsonResponse
    {
        return new JsonResponse(['status' => 'ok']);
    }
}
