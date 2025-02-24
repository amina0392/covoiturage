<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Enum\ReservationStatut;
use App\Repository\ReservationRepository;
use App\Repository\UtilisateurRepository;
use App\Repository\TrajetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

final class ApiReservationController extends AbstractController
{
    #[Route('/api/reservation', name: 'creation_reservation', methods: ['POST'])]
    public function creationReservation(
        Request $request,
        EntityManagerInterface $entityManager,
        UtilisateurRepository $utilisateurRepo,
        TrajetRepository $trajetRepo,
        ValidatorInterface $validator
    ): JsonResponse {
        $data = json_decode($request->getContent(), true);

        if (!$data) {
            return new JsonResponse(['error' => 'Invalid JSON'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $utilisateur = $utilisateurRepo->find($data['id_utilisateur'] ?? null);
        $trajet = $trajetRepo->find($data['id_trajet'] ?? null);

        if (!$utilisateur || !$trajet) {
            return new JsonResponse(['error' => 'Invalid user or trip IDs'], JsonResponse::HTTP_BAD_REQUEST);
        }

        if ($trajet->getPlacesRestantes() <= 0) {
            return new JsonResponse(['message' => 'RÃ©servation impossible (plus de place)', 'status' => 'NOK'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $reservation = new Reservation();
        $reservation->setUtilisateur($utilisateur);
        $reservation->setTrajet($trajet);
        $reservation->setStatut(ReservationStatut::EN_ATTENTE);
        $reservation->setDateReservation(new \DateTime());

        $errors = $validator->validate($reservation);
        if (count($errors) > 0) {
            return new JsonResponse(['error' => (string) $errors, 'status' => 'NOK'], JsonResponse::HTTP_BAD_REQUEST);
        }

        $trajet->setPlacesRestantes($trajet->getPlacesRestantes() - 1);

        $entityManager->persist($reservation);
        $entityManager->persist($trajet);
        $entityManager->flush();

        return new JsonResponse(['message' => 'RÃ©servation effectuÃ©e', 'status' => 'OK'], JsonResponse::HTTP_CREATED);
    }

    #[Route('/api/reservation/{id}/confirmer', name: 'confirmer_reservation', methods: ['PUT'])]
    public function confirmerReservation(int $id, ReservationRepository $reservationRepo, EntityManagerInterface $entityManager): JsonResponse
    {
        $reservation = $reservationRepo->find($id);

        if (!$reservation) {
            return new JsonResponse(['error' => 'RÃ©servation non trouvÃ©e'], JsonResponse::HTTP_NOT_FOUND);
        }

        $currentUser = $this->getUser();
        if ($reservation->getTrajet()->getConducteur() !== $currentUser) {
            return new JsonResponse(['error' => 'AccÃ¨s refusÃ©'], JsonResponse::HTTP_FORBIDDEN);
        }

        $reservation->setStatut(ReservationStatut::CONFIRMEE);
        $entityManager->persist($reservation);
        $entityManager->flush();

        return new JsonResponse(['message' => 'RÃ©servation confirmÃ©e avec succÃ¨s'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/reservation/{id}/annuler', name: 'annuler_reservation', methods: ['PUT'])]
    public function annulerReservation(int $id, ReservationRepository $reservationRepo, EntityManagerInterface $entityManager): JsonResponse
    {
        $reservation = $reservationRepo->find($id);

        if (!$reservation) {
            return new JsonResponse(['error' => 'RÃ©servation non trouvÃ©e'], JsonResponse::HTTP_NOT_FOUND);
        }

        $currentUser = $this->getUser();
        if ($reservation->getUtilisateur() !== $currentUser) {
            return new JsonResponse(['error' => 'AccÃ¨s refusÃ©'], JsonResponse::HTTP_FORBIDDEN);
        }

        $trajet = $reservation->getTrajet();
        $trajet->setPlacesRestantes($trajet->getPlacesRestantes() + 1);

        $reservation->setStatut(ReservationStatut::ANNULEE);

        $entityManager->persist($trajet);
        $entityManager->persist($reservation);
        $entityManager->flush();

        return new JsonResponse(['message' => 'RÃ©servation annulÃ©e avec succÃ¨s'], JsonResponse::HTTP_OK);
    }

    #[Route('/api/reservation', name: 'liste_reservations', methods: ['GET'])]
    public function listeReservations(ReservationRepository $reservationRepo): JsonResponse
    {
        $reservations = $reservationRepo->findAll();

        $data = [];
        foreach ($reservations as $reservation) {
            $trajet = $reservation->getTrajet();
            $conducteur = $trajet->getConducteur();

            $data[] = [
                'id' => $reservation->getIdReservation(),
                'utilisateur' => $reservation->getUtilisateur()->getNom() . ' ' . $reservation->getUtilisateur()->getPrenom(),
                'trajet' => [
                    'id' => $trajet->getIdTrajet(),
                    'ville_depart' => $trajet->getVilleDepart()->getNomCommune(),
                    'ville_arrivee' => $trajet->getVilleArrivee()->getNomCommune(),
                    'date_heure' => $trajet->getDateHeure()->format('Y-m-d H:i:s'),
                    'conducteur' => $conducteur->getNom() . ' ' . $conducteur->getPrenom()
                ],
                'statut' => $reservation->getStatut()->value,
                'date_reservation' => $reservation->getDateReservation()->format('Y-m-d H:i:s')
            ];
        }

        return new JsonResponse($data, JsonResponse::HTTP_OK);
    }


    #[Route('/api/reservation/{id}', name: 'get_reservation', methods: ['GET'])]
    public function getReservation(int $id, ReservationRepository $reservationRepo): JsonResponse
    {
        $reservation = $reservationRepo->find($id);

        if (!$reservation) {
            return new JsonResponse(['error' => 'RÃ©servation non trouvÃ©e'], JsonResponse::HTTP_NOT_FOUND);
        }

        return $this->json($reservation);
    }
}
