<?php

/**
 * This file has been auto-generated
 * by the Symfony Routing Component.
 */

return [
    false, // $matchHost
    [ // $staticRoutes
        '/_wdt/styles' => [[['_route' => '_wdt_stylesheet', '_controller' => 'web_profiler.controller.profiler::toolbarStylesheetAction'], null, null, null, false, false, null]],
        '/_profiler' => [[['_route' => '_profiler_home', '_controller' => 'web_profiler.controller.profiler::homeAction'], null, null, null, true, false, null]],
        '/_profiler/search' => [[['_route' => '_profiler_search', '_controller' => 'web_profiler.controller.profiler::searchAction'], null, null, null, false, false, null]],
        '/_profiler/search_bar' => [[['_route' => '_profiler_search_bar', '_controller' => 'web_profiler.controller.profiler::searchBarAction'], null, null, null, false, false, null]],
        '/_profiler/phpinfo' => [[['_route' => '_profiler_phpinfo', '_controller' => 'web_profiler.controller.profiler::phpinfoAction'], null, null, null, false, false, null]],
        '/_profiler/xdebug' => [[['_route' => '_profiler_xdebug', '_controller' => 'web_profiler.controller.profiler::xdebugAction'], null, null, null, false, false, null]],
        '/_profiler/open' => [[['_route' => '_profiler_open_file', '_controller' => 'web_profiler.controller.profiler::openAction'], null, null, null, false, false, null]],
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
        '/api/login_check' => [
            [['_route' => 'api_login', '_controller' => 'App\\Controller\\SecurityController::login'], null, ['POST' => 0], null, false, false, null],
            [['_route' => 'login_check'], null, ['POST' => 0], null, false, false, null],
        ],
    ],
    [ // $regexpList
        0 => '{^(?'
                .'|/_(?'
                    .'|error/(\\d+)(?:\\.([^/]++))?(*:38)'
                    .'|wdt/([^/]++)(*:57)'
                    .'|profiler/(?'
                        .'|font/([^/\\.]++)\\.woff2(*:98)'
                        .'|([^/]++)(?'
                            .'|/(?'
                                .'|search/results(*:134)'
                                .'|router(*:148)'
                                .'|exception(?'
                                    .'|(*:168)'
                                    .'|\\.css(*:181)'
                                .')'
                            .')'
                            .'|(*:191)'
                        .')'
                    .')'
                .')'
                .'|/api/(?'
                    .'|reservation/([^/]++)(?'
                        .'|/(?'
                            .'|confirmer(*:246)'
                            .'|annuler(*:261)'
                        .')'
                        .'|(*:270)'
                    .')'
                    .'|trajet/([^/]++)(?'
                        .'|(*:297)'
                    .')'
                    .'|conducteur/([^/]++)/passagers(*:335)'
                    .'|utilisateur/([^/]++)(?'
                        .'|/reservation(*:378)'
                        .'|(*:386)'
                    .')'
                    .'|v(?'
                        .'|ille/([^/]++)(*:412)'
                        .'|oiture/([^/]++)(*:435)'
                    .')'
                .')'
            .')/?$}sDu',
    ],
    [ // $dynamicRoutes
        38 => [[['_route' => '_preview_error', '_controller' => 'error_controller::preview', '_format' => 'html'], ['code', '_format'], null, null, false, true, null]],
        57 => [[['_route' => '_wdt', '_controller' => 'web_profiler.controller.profiler::toolbarAction'], ['token'], null, null, false, true, null]],
        98 => [[['_route' => '_profiler_font', '_controller' => 'web_profiler.controller.profiler::fontAction'], ['fontName'], null, null, false, false, null]],
        134 => [[['_route' => '_profiler_search_results', '_controller' => 'web_profiler.controller.profiler::searchResultsAction'], ['token'], null, null, false, false, null]],
        148 => [[['_route' => '_profiler_router', '_controller' => 'web_profiler.controller.router::panelAction'], ['token'], null, null, false, false, null]],
        168 => [[['_route' => '_profiler_exception', '_controller' => 'web_profiler.controller.exception_panel::body'], ['token'], null, null, false, false, null]],
        181 => [[['_route' => '_profiler_exception_css', '_controller' => 'web_profiler.controller.exception_panel::stylesheet'], ['token'], null, null, false, false, null]],
        191 => [[['_route' => '_profiler', '_controller' => 'web_profiler.controller.profiler::panelAction'], ['token'], null, null, false, true, null]],
        246 => [[['_route' => 'confirmer_reservation', '_controller' => 'App\\Controller\\ApiReservationController::confirmerReservation'], ['id'], ['PUT' => 0], null, false, false, null]],
        261 => [[['_route' => 'annuler_reservation', '_controller' => 'App\\Controller\\ApiReservationController::annulerReservation'], ['id'], ['PUT' => 0], null, false, false, null]],
        270 => [[['_route' => 'get_reservation', '_controller' => 'App\\Controller\\ApiReservationController::getReservation'], ['id'], ['GET' => 0], null, false, true, null]],
        297 => [
            [['_route' => 'suppression_trajet', '_controller' => 'App\\Controller\\ApiTrajetController::suppressionTrajet'], ['id'], ['DELETE' => 0], null, false, true, null],
            [['_route' => 'modification_trajet', '_controller' => 'App\\Controller\\ApiTrajetController::modificationTrajet'], ['id'], ['PUT' => 0], null, false, true, null],
        ],
        335 => [[['_route' => 'liste_passagers', '_controller' => 'App\\Controller\\ApiUtilisateurController::listePassagers'], ['idtrajet'], ['GET' => 0], null, false, false, null]],
        378 => [[['_route' => 'liste_reservation_utilisateur', '_controller' => 'App\\Controller\\ApiUtilisateurController::listeReservationUtilisateur'], ['id'], ['GET' => 0], null, false, false, null]],
        386 => [
            [['_route' => 'modification_utilisateur', '_controller' => 'App\\Controller\\ApiUtilisateurController::modificationUtilisateur'], ['id'], ['PUT' => 0], null, false, true, null],
            [['_route' => 'suppression_utilisateur', '_controller' => 'App\\Controller\\ApiUtilisateurController::suppressionUtilisateur'], ['id'], ['DELETE' => 0], null, false, true, null],
        ],
        412 => [[['_route' => 'supprimer_ville', '_controller' => 'App\\Controller\\ApiVilleController::supprimerVille'], ['id'], ['DELETE' => 0], null, false, true, null]],
        435 => [
            [['_route' => 'suppression_voiture', '_controller' => 'App\\Controller\\ApiVoitureController::suppressionVoiture'], ['id'], ['DELETE' => 0], null, false, true, null],
            [null, null, null, null, false, false, 0],
        ],
    ],
    null, // $checkCondition
];
