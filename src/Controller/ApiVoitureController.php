<?php

namespace App\Controller;

use App\Entity\Voiture;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiVoitureController extends AbstractController
{
    #[Route('/api/voiture', name: 'create_voiture', methods: ['POST'])]
    public function createVoiture(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        $voiture = new Voiture();
        $voiture->setMarque($data['marque']);
        $voiture->setModele($data['modele']);
        $voiture->setImmatriculation($data['immatriculation']);
        $voiture->setNbPlaces($data['nb_places']);

        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string) $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($voiture);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Voiture ajoutée avec succès'], JsonResponse::HTTP_CREATED);
    }
}
