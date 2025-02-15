<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Repository\TrajetRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

final class ApiTrajetController extends AbstractController
{
    #[Route('/api/trajet', name: 'create_trajet', methods: ['POST'])]
    public function createTrajet( /* code inchangé pour la création d'un trajet */ ) { /* ... */ }

    #[Route('/api/trajets', name: 'get_trajets', methods: ['GET'])]
    public function getTrajets(TrajetRepository $trajetRepository): JsonResponse
    {
        $trajets = $trajetRepository->findAll();

        $data = [];
        foreach ($trajets as $trajet) {
            $data[] = [
                'id' => $trajet->getIdTrajet(),
                'conducteur' => $trajet->getConducteur()->getNom() . ' ' . $trajet->getConducteur()->getPrenom(),
                'ville_depart' => [
                    'nom_commune' => $trajet->getVilleDepart()->getNomCommune(),
                    'code_postale' => $trajet->getVilleDepart()->getCodePostale()
                ],
                'ville_arrivee' => [
                    'nom_commune' => $trajet->getVilleArrivee()->getNomCommune(),
                    'code_postale' => $trajet->getVilleArrivee()->getCodePostale()
                ],
                'date_heure' => $trajet->getDateHeure()->format('Y-m-d H:i:s'),
                'places_restantes' => $trajet->getPlacesRestantes(),
                'detail_trajet' => $trajet->getDetailTrajet()
            ];
        }

        return new JsonResponse($data);
    }
}
