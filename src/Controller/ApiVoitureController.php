<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiVoitureController extends AbstractController
{
    #[Route('/api/voiture', name: 'app_api_voiture')]
    public function index(): Response
    {
        return $this->render('api_voiture/index.html.twig', [
            'controller_name' => 'ApiVoitureController',
        ]);
    }
}
