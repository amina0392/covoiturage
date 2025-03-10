<?php

namespace App\Controller;

use App\Entity\Voiture;
use App\Repository\UtilisateurRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\SecurityBundle\Security;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ApiVoitureController extends AbstractController
{
    #[Route('/api/voiture', name: 'creation_voiture', methods: ['POST'])]
    public function creationVoiture(Request $request, EntityManagerInterface $entityManager, ValidatorInterface $validator, UtilisateurRepository $utilisateurRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id_utilisateur'])) {
            return new JsonResponse(['error' => 'ID utilisateur manquant'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $utilisateur = $utilisateurRepo->find($data['id_utilisateur']);
        if (!$utilisateur) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        $voiture = new Voiture();
        $voiture->setMarque($data['marque']);
        $voiture->setModele($data['modele']);
        $voiture->setImmatriculation($data['immatriculation']);
        $voiture->setNbPlaces($data['nb_places']);
        $voiture->setUtilisateur($utilisateur);

        $errors = $validator->validate($voiture);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string) $errors], JsonResponse::HTTP_BAD_REQUEST);
        }

        $entityManager->persist($voiture);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Voiture ajoutée avec succès et rattachée à l\'utilisateur',
            'id' => $voiture->getIdVoiture() // ✅ Retour de l'ID
        ], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/voiture/{id}', name: 'suppression_voiture', methods: ['DELETE'])]
    public function suppressionVoiture(int $id, EntityManagerInterface $entityManager, Security $security): JsonResponse
    {
        $voiture = $entityManager->getRepository(Voiture::class)->find($id);

        if (!$voiture) {
            return new JsonResponse(['error' => 'Voiture non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        $utilisateurConnecte = $security->getUser();
        if ($voiture->getUtilisateur() !== $utilisateurConnecte) {
            return new JsonResponse(['error' => 'Vous n\'êtes pas autorisé à supprimer cette voiture'], JsonResponse::HTTP_FORBIDDEN);
        }

        $entityManager->remove($voiture);
        $entityManager->flush();

        return new JsonResponse([
            'message' => 'Voiture supprimée avec succès',
            'id' => $id // ✅ Retour de l'ID
        ], JsonResponse::HTTP_OK);
    }
}
