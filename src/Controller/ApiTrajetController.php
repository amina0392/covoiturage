<?php

namespace App\Controller;

use App\Entity\Trajet;
use App\Entity\Utilisateur;
use App\Repository\TrajetRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

final class ApiTrajetController extends AbstractController
{
    #[Route('/api/trajet', name: 'create_trajet', methods: ['POST'])]
    public function createTrajet(Request $request, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepo, VilleRepository $villeRepo): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        if (!isset($data['id_utilisateur'], $data['id_ville_depart'], $data['id_ville_arrivee'], $data['date_heure'], $data['places_restantes'])) {
            return new JsonResponse(['error' => 'Données manquantes'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $conducteur = $utilisateurRepo->find($data['id_utilisateur']);
        $villeDepart = $villeRepo->find($data['id_ville_depart']);
        $villeArrivee = $villeRepo->find($data['id_ville_arrivee']);

        if (!$conducteur || !$villeDepart || !$villeArrivee) {
            return new JsonResponse(['error' => 'Entités non trouvées'], JsonResponse::HTTP_NOT_FOUND);
        }

        $trajet = new Trajet();
        $trajet->setConducteur($conducteur);
        $trajet->setVilleDepart($villeDepart);
        $trajet->setVilleArrivee($villeArrivee);
        $trajet->setDateHeure(new \DateTime($data['date_heure']));
        $trajet->setPlacesRestantes($data['places_restantes']);
        $trajet->setDetailTrajet($data['detail_trajet'] ?? null);

        $entityManager->persist($trajet);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Trajet créé avec succès'], JsonResponse::HTTP_CREATED);
    }

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

    #[Route('/api/trajets/recherche', name: 'recherche_trajets', methods: ['GET'])]
    public function rechercheTrajets(Request $request, TrajetRepository $trajetRepository): JsonResponse
    {
        $villeDepartId = $request->query->get('ville_depart');
        $villeArriveeId = $request->query->get('ville_arrivee');
        $dateDepart = $request->query->get('date_depart');

        $trajets = $trajetRepository->searchByCriteria($villeDepartId, $villeArriveeId, $dateDepart);

        $data = [];
        foreach ($trajets as $trajet) {
            $data[] = [
                'id' => $trajet->getIdTrajet(),
                'conducteur' => $trajet->getConducteur()->getNom() . ' ' . $trajet->getConducteur()->getPrenom(),
                'ville_depart' => $trajet->getVilleDepart()->getNomCommune(),
                'ville_arrivee' => $trajet->getVilleArrivee()->getNomCommune(),
                'date_heure' => $trajet->getDateHeure()->format('Y-m-d H:i:s'),
                'places_restantes' => $trajet->getPlacesRestantes()
            ];
        }

        return new JsonResponse($data);
    }
    
    #[Route('/api/trajet/{id}', name: 'delete_trajet', methods: ['DELETE'])]
    public function deleteTrajet(int $id, TrajetRepository $trajetRepository, EntityManagerInterface $entityManager): JsonResponse
    {
        $trajet = $trajetRepository->find($id);

        if (!$trajet) {
            return new JsonResponse(['error' => 'Trajet non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($trajet);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Trajet supprimé avec succès'], JsonResponse::HTTP_OK);
    }
}
