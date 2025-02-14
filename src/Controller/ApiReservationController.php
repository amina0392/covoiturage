<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiReservationController extends AbstractController
{
    #[Route('/api/reservation', name: 'app_api_reservation')]
    public function index(): Response
    {
        return $this->render('api_reservation/index.html.twig', [
            'controller_name' => 'ApiReservationController',
        ]);
    }
}
