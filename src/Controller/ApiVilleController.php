<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiVilleController extends AbstractController
{
    #[Route('/api/ville', name: 'app_api_ville')]
    public function index(): Response
    {
        return $this->render('api_ville/index.html.twig', [
            'controller_name' => 'ApiVilleController',
        ]);
    }
}
