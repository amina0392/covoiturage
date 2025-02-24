<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ApiAuthController extends AbstractController
{
    #[Route('/api/auth', name: 'app_api_auth')]
    public function index(): Response
    {
        return $this->render('api_auth/index.html.twig', [
            'controller_name' => 'ApiAuthController',
        ]);
    }
}
