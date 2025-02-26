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

    #[Route('/api/ville', name: 'ajout_ville', methods: ['POST'])]
    public function ajoutVille(Request $request, EntityManagerInterface $entityManager): JsonResponse
    {
        $currentUser = $this->security->getUser();

        if (!$currentUser || !in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return new JsonResponse(['error' => 'AccÃƒÂ¨s refusÃƒÂ©'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = json_decode($request->getContent(), true);

        if (!isset($data['nom_commune'], $data['code_postale'])) {
            return new JsonResponse(['error' => 'DonnÃƒÂ©es incomplÃƒÂ¨tes'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $ville = new Ville();
        $ville->setNomCommune($data['nom_commune']);
        $ville->setCodePostale($data['code_postale']);

        $entityManager->persist($ville);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Ville ajoutÃƒÂ©e avec succÃƒÂ¨s'], JsonResponse::HTTP_CREATED);
    }

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

    #[Route('/api/ville/recherche', name: 'recherche_ville', methods: ['GET'])]
    public function rechercheVille(Request $request, VilleRepository $villeRepo): JsonResponse
    {
        $nomCommune = $request->query->get('nom_commune');
        $codePostale = $request->query->get('code_postale');

        if (!$nomCommune || !$codePostale) {
            return new JsonResponse(['error' => 'ParamÃƒÂ¨tres manquants'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $ville = $villeRepo->findOneBy([
            'nomCommune' => $nomCommune,
            'codePostale' => $codePostale
        ]);

        if (!$ville) {
            return new JsonResponse(['error' => 'Ville non trouvÃƒÂ©e'], JsonResponse::HTTP_NOT_FOUND);
        }

        return new JsonResponse([
            'id' => $ville->getIdVille(),
            'nom_commune' => $ville->getNomCommune(),
            'code_postale' => $ville->getCodePostale(),
        ], JsonResponse::HTTP_OK);
    }

   
    #[Route('/api/ville/{id}', name: 'supprimer_ville', methods: ['DELETE'])]
    public function supprimerVille(int $id, EntityManagerInterface $entityManager, VilleRepository $villeRepo): JsonResponse
    {
        $currentUser = $this->security->getUser();

        if (!$currentUser || !in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return new JsonResponse(['error' => 'AccÃƒÂ¨s refusÃƒÂ©'], JsonResponse::HTTP_FORBIDDEN);
        }

        $ville = $villeRepo->find($id);

        if (!$ville) {
            return new JsonResponse(['error' => 'Ville non trouvÃƒÂ©e'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($ville);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Ville supprimÃƒÂ©e avec succÃƒÂ¨s'], JsonResponse::HTTP_OK);
    }
}
