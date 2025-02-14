<?php

namespace App\Enum;

enum ReservationStatut: string {
    case EN_ATTENTE = 'en attente';
    case CONFIRMEE = 'confirmée';
    case ANNULEE = 'annulée';
}

