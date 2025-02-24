<?php

namespace App\Enum;

enum ReservationStatut: string {
    case EN_ATTENTE = 'en attente';
    case CONFIRMEE = 'confirmÃ©e';
    case ANNULEE = 'annulÃ©e';
}

