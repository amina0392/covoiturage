<?php

namespace App\Controller;

use App\Entity\Utilisateur;
use App\Entity\Reservation;
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
    #[Route('/api/utilisateur', name: 'create_utilisateur', methods: ['POST'])]
    public function createUtilisateur(
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

        $entityManager->persist($user);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Utilisateur créé avec succès'], Response::HTTP_CREATED);
    }

    #[Route('/api/utilisateur', name: 'liste_utilisateurs', methods: ['GET'])]
    public function listeUtilisateurs(ReservationRepository $reservationRepo): JsonResponse {
        $reservations = $reservationRepo->findAll();
        $data = [];
        foreach ($reservations as $reservation) { 
            $data[] = [
                'id' => $reservation->getIdReservation(),
                'utilisateur' => $reservation->getUtilisateur()->getNom().' '.$reservation->getUtilisateur()->getPrenom(),
                'trajet' => $reservation->getTrajet()->getIdTrajet(),
                'statut' => $reservation->getStatut()->value,
                'date_reservation' => $reservation->getDateReservation()->format('Y-m-d H:i:s')
            ];
        }
        return new JsonResponse($data);
    }


    #[Route('/api/conducteur/{idtrajet}/passagers', name: 'liste_passagers_conducteur', methods: ['GET'])]
    public function listePassagersConducteur(int $idtrajet, ReservationRepository $reservationRepo): JsonResponse {
        $reservations = $reservationRepo->findBy(['trajet' => $idtrajet]);
        $data = [];
        foreach ($reservations as $reservation) {
            $data[] = [
                'id' => $reservation->getIdReservation(),
                'utilisateur' => $reservation->getUtilisateur()->getNom().' '.$reservation->getUtilisateur()->getPrenom()
            ];
        }
        return new JsonResponse($data);
    }

    #[Route('/api/utilisateur/{idpers}/inscriptions', name: 'liste_inscriptions_user', methods: ['GET'])]
    public function listeInscriptionsUser(int $idpers, ReservationRepository $reservationRepo): JsonResponse {
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

    #[Route('/api/inscription/{id}', name: 'delete_inscription', methods: ['DELETE'])]
    public function deleteInscription(int $id, EntityManagerInterface $entityManager, ReservationRepository $reservationRepo): JsonResponse {
        $reservation = $reservationRepo->find($id);
        if (!$reservation) {
            return new JsonResponse(['error' => 'Inscription non trouvée'], JsonResponse::HTTP_NOT_FOUND);
        }

        $entityManager->remove($reservation);
        $entityManager->flush();

        return new JsonResponse(['message' => 'Inscription supprimée avec succès'], JsonResponse::HTTP_OK);
    }

}
