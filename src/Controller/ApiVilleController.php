<?php

namespace App\Controller;

use App\Entity\Ville;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\SecurityBundle\Security;

final class ApiVilleController extends AbstractController
{
    private Security $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    // ✅ Ajouter une ville (ADMIN ONLY)
    #[Route('/api/ville', name: 'ajout_ville', methods: ['POST'])]
    public function ajoutVille(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $currentUser = $this->security->getUser();

        // Vérification si l'utilisateur est admin
        if (!$currentUser || !in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return new JsonResponse(['error' => 'Accès refusé'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom_commune'], $data['code_postale'])) {
            return new JsonResponse(['error' => 'Données incomplètes'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $ville = new Ville();
        $ville->setNomCommune($data['nom_commune']);
        $ville->setCodePostale($data['code_postale']);

        $entityManager->persist($ville);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Ville ajoutée avec succès'], JsonResponse::HTTP_CREATED);
    }

    // ✅ Afficher toutes les villes (Accès public)
    #[Route('/api/villes', name: 'liste_villes', methods: ['GET'])]
    public function listeVilles(VilleRepository $villeRepo): JsonResponse
    {
        $villes = $villeRepo->findAll();
        $data = [];

        foreach ($villes as $ville) {
            $data[] = [
                'id' => $ville->getIdVille(),
                'nom_commune' => $ville->getNomCommune(),
                'code_postale' => $ville->getCodePostale(),
            ];
        }

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }

    // ✅ Trouver une ville par son nom et code postal (Accès public)
    #[Route('/api/ville/recherche', name: 'recherche_ville', methods: ['GET'])]
    public function rechercheVille(Request $request, VilleRepository $villeRepo): JsonResponse
    {
        $nomCommune = $request->query->get('nom_commune');
        $codePostale = $request->query->get('code_postale');

        if (!$nomCommune || !$codePostale) {
            return new JsonResponse(['error' => 'Paramètres manquants'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $ville = $villeRepo->findOneBy([
            'nomCommune' => $nomCommune,
            'codePostale' => $codePostale
        ]);

        if (!$ville) {
            return new JsonResponse(['error' => 'Ville non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $ville->getIdVille(),
            'nom_commune' => $ville->getNomCommune(),
            'code_postale' => $ville->getCodePostale(),
        ], JsonResponse::HTTP_OK);
    }

    // ✅ Supprimer une ville par ID (ADMIN ONLY)
    #[Route('/api/ville/{id}', name: 'supprimer_ville', methods: ['DELETE'])]
    public function supprimerVille(int $id, EntityManagerInterface $entityManager, VilleRepository $villeRepo): JsonResponse
    {
        $currentUser = $this->security->getUser();

        // Vérification si l'utilisateur est admin
        if (!$currentUser || !in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return new JsonResponse(['error' => 'Accès refusé'], JsonResponse::HTTP_FORBIDDEN);
        }

        $ville = $villeRepo->find($id);

        if (!$ville) {
            return new JsonResponse(['error' => 'Ville non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($ville);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Ville supprimée avec succès'], JsonResponse::HTTP_OK);
    }
}
