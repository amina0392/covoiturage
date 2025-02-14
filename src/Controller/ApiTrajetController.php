<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiTrajetController extends AbstractController
{
    #[Route('/api/trajet', name: 'app_api_trajet')]
    public function index(): Response
    {
        return $this->render('api_trajet/index.html.twig', [
            'controller_name' => 'ApiTrajetController',
        ]);
    }
}
