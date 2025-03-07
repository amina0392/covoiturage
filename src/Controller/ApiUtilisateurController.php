<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Voiture;
use Symfony\Bundle\SecurityBundle\Security;
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
    
        // Vérification des champs requis
        if (!isset($data['nom'], $data['prenom'], $data['email'], $data['motDePasse'], $data['idRole'], $data['idVille'])) {
            return new JsonResponse(['error' => 'Données invalides'], Response::HTTP_BAD_REQUEST);
        }
    
        // Vérifier si l'email existe déjà
        $existingUser = $entityManager->getRepository(Utilisateur::class)->findOneBy(['email' => $data['email']]);
        if ($existingUser) {
            return new JsonResponse(['error' => 'Email déjà utilisé'], Response::HTTP_CONFLICT);
        }
    
        $user = new Utilisateur();
        $user->setNom($data['nom']);
        $user->setPrenom($data['prenom']);
        $user->setEmail($data['email']);
        $user->setPassword($passwordHasher->hashPassword($user, $data['motDePasse']));
    
        // Assigner le rôle et la ville
        $role = $roleRepo->find($data['idRole']);
        $ville = $villeRepo->find($data['idVille']);
    
        if (!$role || !$ville) {
            return new JsonResponse([
                'error' => 'Rôle ou ville invalide',
                'idRole' => $data['idRole'],
                'idVille' => $data['idVille']
            ], Response::HTTP_BAD_REQUEST);
        }
    
        $user->setRoleEntity($role);
        $user->setVille($ville);
    
        // Vérifier et ajouter une voiture si fournie
        if (isset($data['voiture'])) {
            $voitureData = $data['voiture'];
            $voiture = new Voiture();
            $voiture->setMarque($voitureData['marque']);
            $voiture->setModele($voitureData['modele']);
            $voiture->setImmatriculation($voitureData['immatriculation']);
            $voiture->setNbPlaces($voitureData['nb_places']);
            $voiture->setUtilisateur($user);
            $user->setVoiture($voiture);
    
            $entityManager->persist($voiture);
        }
    
        $entityManager->persist($user);
        $entityManager->flush();
    
        return new JsonResponse([
            'message' => 'Utilisateur créé avec succès',
            'id' => $user->getIdUtilisateur() // Ajout de l'ID utilisateur
        ], Response::HTTP_CREATED);
    }
    
    #[Route('/api/utilisateurs', name: 'liste_utilisateurs', methods: ['GET'])]
    public function listeUtilisateurs(UtilisateurRepository $utilisateurRepo): JsonResponse
    {
        $currentUser = $this->getUser();

        if (!$currentUser || !in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return new JsonResponse(['error' => 'AccÃƒÂ¨s refusÃƒÂ©'], JsonResponse::HTTP_FORBIDDEN);
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

    #[Route('/api/utilisateur/{id}', name: 'modification_utilisateur', methods: ['PUT'])]
    public function modificationUtilisateur(
        int $id,
        Request $request,
        EntityManagerInterface $entityManager,
        UtilisateurRepository $utilisateurRepo,
        VilleRepository $villeRepo,
        Security $security
    ): JsonResponse {
       
        $utilisateurConnecte = $security->getUser();

      
        $utilisateur = $utilisateurRepo->find($id);
        if (!$utilisateur) {
            return new JsonResponse(['error' => 'Utilisateur non trouvÃƒÂ©'], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($utilisateurConnecte !== $utilisateur) {
            return new JsonResponse(['error' => 'AccÃƒÂ¨s refusÃƒÂ©'], JsonResponse::HTTP_FORBIDDEN);
        }

        $data = json_decode($request->getContent(), true);

        if (isset($data['nom'])) {
            $utilisateur->setNom($data['nom']);
        }
        if (isset($data['prenom'])) {
            $utilisateur->setPrenom($data['prenom']);
        }
        if (isset($data['email'])) {
            $utilisateur->setEmail($data['email']);
        }
        if (isset($data['idVille'])) {
            $ville = $villeRepo->find($data['idVille']);
            if ($ville) {
                $utilisateur->setVille($ville);
            } else {
                return new JsonResponse(['error' => 'Ville non trouvÃƒÂ©e'], JsonResponse::HTTP_NOT_FOUND);
            }
        }

       
        if (isset($data['idRole'])) {
            return new JsonResponse(['error' => 'Modification du rÃƒÂ´le interdite'], JsonResponse::HTTP_FORBIDDEN);
        }

        $entityManager->persist($utilisateur);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur mis ÃƒÂ  jour avec succÃƒÂ¨s'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/utilisateur/{id}', name: 'suppression_utilisateur', methods: ['DELETE'])]
    public function suppressionUtilisateur(
        int $id,
        EntityManagerInterface $entityManager,
        UtilisateurRepository $utilisateurRepo,
        Security $security
    ): JsonResponse {
        $currentUser = $security->getUser(); 

        if (!$currentUser) {
            return new JsonResponse(['error' => 'AccÃƒÂ¨s refusÃƒÂ©'], JsonResponse::HTTP_FORBIDDEN);
        }

        $utilisateur = $utilisateurRepo->find($id);

        if (!$utilisateur) {
            return new JsonResponse(['error' => 'Utilisateur non trouvÃƒÂ©'], JsonResponse::HTTP_NOT_FOUND);
        }

        if ($currentUser !== $utilisateur && !in_array('ROLE_ADMIN', $currentUser->getRoles())) {
            return new JsonResponse(['error' => 'AccÃƒÂ¨s refusÃƒÂ©'], JsonResponse::HTTP_FORBIDDEN);
        }

        $entityManager->remove($utilisateur);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur supprimÃƒÂ© avec succÃƒÂ¨s'], JsonResponse::HTTP_OK);
    }
}
