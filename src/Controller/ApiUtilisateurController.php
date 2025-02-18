<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Voiture;

use App\Repository\UtilisateurRepository;
use App\Repository\RoleRepository;
use App\Repository\ReservationRepository;
use App\Repository\VilleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\HttpFoundation\Response;


final class ApiUtilisateurController extends AbstractController
{
    #[Route('/api/utilisateur', name: 'inscription_utilisateur', methods: ['POST'])]
    public function inscriptionUtilisateur(
        Request $request,
        EntityManagerInterface $entityManager,
        UserPasswordHasherInterface $passwordHasher,
        RoleRepository $roleRepo,
        VilleRepository $villeRepo
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);
    
        $user = new Utilisateur();
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['motDePasse']));
    
        $role = $roleRepo->find($data['idRole']);
        $ville = $villeRepo->find($data['idVille']);
    
        $user->setRoleEntity($role);
        $user->setVille($ville);
    
        if (isset($data['voiture'])) {
            $voitureData = $data['voiture'];
            $voiture = new Voiture();
            $voiture->setMarque($voitureData['marque']);
            $voiture->setModele($voitureData['modele']);
            $voiture->setImmatriculation($voitureData['immatriculation']);
            $voiture->setNbPlaces($voitureData['nb_places']);
    
            // Associe voiture et utilisateur dans les deux sens
            $voiture->setUtilisateur($user);
            $user->setVoiture($voiture);
    
            $entityManager->persist($voiture);
        }
    
        $entityManager->persist($user);
        $entityManager->flush(); // Un seul flush après toutes les opérations
    
        return new JsonResponse(['message' => 'Utilisateur et voiture créés avec succès'], Response::HTTP_CREATED);
    }
    

    #[Route('/api/utilisateurs', name: 'liste_utilisateurs', methods: ['GET'])]
public function listeUtilisateurs(UtilisateurRepository $utilisateurRepo): JsonResponse
{
    $currentUser = $this->getUser();

    if (!$currentUser || !in_array('ROLE_ADMIN', $currentUser->getRoles())) {
        return new JsonResponse(['error' => 'Accès refusé'], JsonResponse::HTTP_FORBIDDEN);
    }

    $utilisateurs = $utilisateurRepo->findAll();
    $data = [];

    foreach ($utilisateurs as $user) {
        $voiture = $user->getVoiture();

        $data[] = [
            'id' => $user->getIdUtilisateur(),
            'nom' => $user->getNom(),
            'prenom' => $user->getPrenom(),
            'email' => $user->getEmail(),
            'ville' => $user->getVille()->getNomCommune(),
            'role' => in_array('ROLE_ADMIN', $user->getRoles()) ? 'ROLE_ADMIN' : 'ROLE_USER',
            'voiture' => $voiture ? [
                'id' => $voiture->getIdVoiture(),
                'marque' => $voiture->getMarque(),
                'modele' => $voiture->getModele(),
                'immatriculation' => $voiture->getImmatriculation(),
                'nb_places' => $voiture->getNbPlaces(),
            ] : null
        ];
    }

    return new JsonResponse($data);
}



    #[Route('/api/conducteur/{idtrajet}/passagers', name: 'liste_passagers', methods: ['GET'])]
    public function listePassagers(int $idtrajet, ReservationRepository $reservationRepo): JsonResponse
    {
        $reservations = $reservationRepo->findBy(['trajet' => $idtrajet]);
        $data = [];
        foreach ($reservations as $reservation) {
            $data[] = [
                'id' => $reservation->getIdReservation(),
                'utilisateur' => $reservation->getUtilisateur()->getNom() . ' ' . $reservation->getUtilisateur()->getPrenom()
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/api/utilisateur/{id}/reservation', name: 'liste_reservation_utilisateur', methods: ['GET'])]
    public function listeReservationUtilisateur(int $idpers, ReservationRepository $reservationRepo): JsonResponse
    {
        $reservations = $reservationRepo->findBy(['utilisateur' => $idpers]);
        $data = [];
        foreach ($reservations as $reservation) {
            $data[] = [
                'id' => $reservation->getIdReservation(),
                'trajet' => $reservation->getTrajet()->getIdTrajet(),
                'statut' => $reservation->getStatut()->value,
                'date_reservation' => $reservation->getDateReservation()->format('Y-m-d H:i:s')
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/api/utilisateur/{id}', name: 'suppression_utilisateur', methods: ['DELETE'])]
    public function deleteUtilisateur(int $id, EntityManagerInterface $entityManager, UtilisateurRepository $utilisateurRepo): JsonResponse
    {
        $currentUser = $this->getUser();

        if (!$currentUser || !$currentUser->getRoles() || !in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return new JsonResponse(['error' => 'Accès refusé'], JsonResponse::HTTP_FORBIDDEN);
        }

        $utilisateur = $utilisateurRepo->find($id);
        if (!$utilisateur) {
            return new JsonResponse(['error' => 'Utilisateur non trouvé'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($utilisateur);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur supprimé avec succès'], JsonResponse::HTTP_OK);
    }
}
