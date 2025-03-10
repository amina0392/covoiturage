<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/api/auth' => [[['_route' => 'app_api_auth', '_controller' => 'App\\Controller\\ApiAuthController::index'], null, null, null, false, false, null]],
        '/api/reservation' => [
            [['_route' => 'creation_reservation', '_controller' => 'App\\Controller\\ApiReservationController::creationReservation'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'liste_reservations', '_controller' => 'App\\Controller\\ApiReservationController::listeReservations'], null, ['GET' => 0], null, false, false, null],
        ],
        '/api/trajet' => [[['_route' => 'creation_trajet', '_controller' => 'App\\Controller\\ApiTrajetController::creationTrajet'], null, ['POST' => 0], null, false, false, null]],
        '/api/trajets' => [[['_route' => 'liste_trajets', '_controller' => 'App\\Controller\\ApiTrajetController::listeTrajets'], null, ['GET' => 0], null, false, false, null]],
        '/api/trajets/recherche' => [[['_route' => 'recherche_trajets', '_controller' => 'App\\Controller\\ApiTrajetController::rechercheTrajets'], null, ['GET' => 0], null, false, false, null]],
        '/api/utilisateur' => [[['_route' => 'inscription_utilisateur', '_controller' => 'App\\Controller\\ApiUtilisateurController::inscriptionUtilisateur'], null, ['POST' => 0], null, false, false, null]],
        '/api/utilisateurs' => [[['_route' => 'liste_utilisateurs', '_controller' => 'App\\Controller\\ApiUtilisateurController::listeUtilisateurs'], null, ['GET' => 0], null, false, false, null]],
        '/api/roles' => [[['_route' => 'liste_roles', '_controller' => 'App\\Controller\\ApiUtilisateurController::listeRoles'], null, ['GET' => 0], null, false, false, null]],
        '/api/ville' => [[['_route' => 'ajout_ville', '_controller' => 'App\\Controller\\ApiVilleController::ajoutVille'], null, ['POST' => 0], null, false, false, null]],
        '/api/villes' => [[['_route' => 'liste_villes', '_controller' => 'App\\Controller\\ApiVilleController::listeVilles'], null, ['GET' => 0], null, false, false, null]],
        '/api/ville/recherche' => [[['_route' => 'recherche_ville', '_controller' => 'App\\Controller\\ApiVilleController::rechercheVille'], null, ['GET' => 0], null, false, false, null]],
        '/api/voiture' => [[['_route' => 'creation_voiture', '_controller' => 'App\\Controller\\ApiVoitureController::creationVoiture'], null, ['POST' => 0], null, false, false, null]],
        '/api/voitures' => [[['_route' => 'liste_voitures', '_controller' => 'App\\Controller\\ApiVoitureController::listeVoitures'], null, ['GET' => 0], null, false, false, null]],
        '/api/healthcheck' => [[['_route' => 'health_check', '_controller' => 'App\\Controller\\HealthCheckController::healthCheck'], null, ['GET' => 0], null, false, false, null]],
        '/api/login_check' => [
            [['_route' => 'api_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'login_check'], null, ['POST' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/api/(?'
                    .'|reservation/([^/]++)(?'
                        .'|/(?'
                            .'|confirmer(*:51)'
                            .'|annuler(*:65)'
                        .')'
                        .'|(*:73)'
                    .')'
                    .'|trajet/([^/]++)(?'
                        .'|(*:99)'
                    .')'
                    .'|conducteur/([^/]++)/passagers(*:136)'
                    .'|utilisateur/([^/]++)(?'
                        .'|/reservation(*:179)'
                        .'|(*:187)'
                    .')'
                    .'|v(?'
                        .'|ille/([^/]++)(*:213)'
                        .'|oiture/([^/]++)(*:236)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        51 => [[['_route' => 'confirmer_reservation', '_controller' => 'App\\Controller\\ApiReservationController::confirmerReservation'], ['id'], ['PUT' => 0], null, false, false, null]],
        65 => [[['_route' => 'annuler_reservation', '_controller' => 'App\\Controller\\ApiReservationController::annulerReservation'], ['id'], ['PUT' => 0], null, false, false, null]],
        73 => [[['_route' => 'get_reservation', '_controller' => 'App\\Controller\\ApiReservationController::getReservation'], ['id'], ['GET' => 0], null, false, true, null]],
        99 => [
            [['_route' => 'suppression_trajet', '_controller' => 'App\\Controller\\ApiTrajetController::suppressionTrajet'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'modification_trajet', '_controller' => 'App\\Controller\\ApiTrajetController::modificationTrajet'], ['id'], ['PUT' => 0], null, false, true, null],
        ],
        136 => [[['_route' => 'liste_passagers', '_controller' => 'App\\Controller\\ApiUtilisateurController::listePassagers'], ['idtrajet'], ['GET' => 0], null, false, false, null]],
        179 => [[['_route' => 'liste_reservation_utilisateur', '_controller' => 'App\\Controller\\ApiUtilisateurController::listeReservationUtilisateur'], ['id'], ['GET' => 0], null, false, false, null]],
        187 => [
            [['_route' => 'modification_utilisateur', '_controller' => 'App\\Controller\\ApiUtilisateurController::modificationUtilisateur'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'suppression_utilisateur', '_controller' => 'App\\Controller\\ApiUtilisateurController::suppressionUtilisateur'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        213 => [[['_route' => 'supprimer_ville', '_controller' => 'App\\Controller\\ApiVilleController::supprimerVille'], ['id'], ['DELETE' => 0], null, false, true, null]],
        236 => [
            [['_route' => 'suppression_voiture', '_controller' => 'App\\Controller\\ApiVoitureController::suppressionVoiture'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
