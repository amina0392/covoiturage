<?php

// This file has been auto-generated by the Symfony Routing Component.

return [
    '_preview_error' => [['code', '_format'], ['_controller' => 'error_controller::preview', '_format' => 'html'], ['code' => '\\d+'], [['variable', '.', '[^/]++', '_format', true], ['variable', '/', '\\d+', 'code', true], ['text', '/_error']], [], [], []],
    '_wdt_stylesheet' => [[], ['_controller' => 'web_profiler.controller.profiler::toolbarStylesheetAction'], [], [['text', '/_wdt/styles']], [], [], []],
    '_wdt' => [['token'], ['_controller' => 'web_profiler.controller.profiler::toolbarAction'], [], [['variable', '/', '[^/]++', 'token', true], ['text', '/_wdt']], [], [], []],
    '_profiler_home' => [[], ['_controller' => 'web_profiler.controller.profiler::homeAction'], [], [['text', '/_profiler/']], [], [], []],
    '_profiler_search' => [[], ['_controller' => 'web_profiler.controller.profiler::searchAction'], [], [['text', '/_profiler/search']], [], [], []],
    '_profiler_search_bar' => [[], ['_controller' => 'web_profiler.controller.profiler::searchBarAction'], [], [['text', '/_profiler/search_bar']], [], [], []],
    '_profiler_phpinfo' => [[], ['_controller' => 'web_profiler.controller.profiler::phpinfoAction'], [], [['text', '/_profiler/phpinfo']], [], [], []],
    '_profiler_xdebug' => [[], ['_controller' => 'web_profiler.controller.profiler::xdebugAction'], [], [['text', '/_profiler/xdebug']], [], [], []],
    '_profiler_font' => [['fontName'], ['_controller' => 'web_profiler.controller.profiler::fontAction'], [], [['text', '.woff2'], ['variable', '/', '[^/\\.]++', 'fontName', true], ['text', '/_profiler/font']], [], [], []],
    '_profiler_search_results' => [['token'], ['_controller' => 'web_profiler.controller.profiler::searchResultsAction'], [], [['text', '/search/results'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_open_file' => [[], ['_controller' => 'web_profiler.controller.profiler::openAction'], [], [['text', '/_profiler/open']], [], [], []],
    '_profiler' => [['token'], ['_controller' => 'web_profiler.controller.profiler::panelAction'], [], [['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_router' => [['token'], ['_controller' => 'web_profiler.controller.router::panelAction'], [], [['text', '/router'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_exception' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::body'], [], [['text', '/exception'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    '_profiler_exception_css' => [['token'], ['_controller' => 'web_profiler.controller.exception_panel::stylesheet'], [], [['text', '/exception.css'], ['variable', '/', '[^/]++', 'token', true], ['text', '/_profiler']], [], [], []],
    'app_api_auth' => [[], ['_controller' => 'App\\Controller\\ApiAuthController::index'], [], [['text', '/api/auth']], [], [], []],
    'creation_reservation' => [[], ['_controller' => 'App\\Controller\\ApiReservationController::creationReservation'], [], [['text', '/api/reservation']], [], [], []],
    'confirmer_reservation' => [['id'], ['_controller' => 'App\\Controller\\ApiReservationController::confirmerReservation'], [], [['text', '/confirmer'], ['variable', '/', '[^/]++', 'id', true], ['text', '/api/reservation']], [], [], []],
    'annuler_reservation' => [['id'], ['_controller' => 'App\\Controller\\ApiReservationController::annulerReservation'], [], [['text', '/annuler'], ['variable', '/', '[^/]++', 'id', true], ['text', '/api/reservation']], [], [], []],
    'liste_reservations' => [[], ['_controller' => 'App\\Controller\\ApiReservationController::listeReservations'], [], [['text', '/api/reservation']], [], [], []],
    'get_reservation' => [['id'], ['_controller' => 'App\\Controller\\ApiReservationController::getReservation'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/reservation']], [], [], []],
    'creation_trajet' => [[], ['_controller' => 'App\\Controller\\ApiTrajetController::creationTrajet'], [], [['text', '/api/trajet']], [], [], []],
    'liste_trajets' => [[], ['_controller' => 'App\\Controller\\ApiTrajetController::listeTrajets'], [], [['text', '/api/trajets']], [], [], []],
    'recherche_trajets' => [[], ['_controller' => 'App\\Controller\\ApiTrajetController::rechercheTrajets'], [], [['text', '/api/trajets/recherche']], [], [], []],
    'suppression_trajet' => [['id'], ['_controller' => 'App\\Controller\\ApiTrajetController::suppressionTrajet'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/trajet']], [], [], []],
    'modification_trajet' => [['id'], ['_controller' => 'App\\Controller\\ApiTrajetController::modificationTrajet'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/trajet']], [], [], []],
    'inscription_utilisateur' => [[], ['_controller' => 'App\\Controller\\ApiUtilisateurController::inscriptionUtilisateur'], [], [['text', '/api/utilisateur']], [], [], []],
    'liste_utilisateurs' => [[], ['_controller' => 'App\\Controller\\ApiUtilisateurController::listeUtilisateurs'], [], [['text', '/api/utilisateurs']], [], [], []],
    'liste_passagers' => [['idtrajet'], ['_controller' => 'App\\Controller\\ApiUtilisateurController::listePassagers'], [], [['text', '/passagers'], ['variable', '/', '[^/]++', 'idtrajet', true], ['text', '/api/conducteur']], [], [], []],
    'liste_reservation_utilisateur' => [['id'], ['_controller' => 'App\\Controller\\ApiUtilisateurController::listeReservationUtilisateur'], [], [['text', '/reservation'], ['variable', '/', '[^/]++', 'id', true], ['text', '/api/utilisateur']], [], [], []],
    'modification_utilisateur' => [['id'], ['_controller' => 'App\\Controller\\ApiUtilisateurController::modificationUtilisateur'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/utilisateur']], [], [], []],
    'suppression_utilisateur' => [['id'], ['_controller' => 'App\\Controller\\ApiUtilisateurController::suppressionUtilisateur'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/utilisateur']], [], [], []],
    'liste_roles' => [[], ['_controller' => 'App\\Controller\\ApiUtilisateurController::listeRoles'], [], [['text', '/api/roles']], [], [], []],
    'ajout_ville' => [[], ['_controller' => 'App\\Controller\\ApiVilleController::ajoutVille'], [], [['text', '/api/ville']], [], [], []],
    'liste_villes' => [[], ['_controller' => 'App\\Controller\\ApiVilleController::listeVilles'], [], [['text', '/api/villes']], [], [], []],
    'recherche_ville' => [[], ['_controller' => 'App\\Controller\\ApiVilleController::rechercheVille'], [], [['text', '/api/ville/recherche']], [], [], []],
    'supprimer_ville' => [['id'], ['_controller' => 'App\\Controller\\ApiVilleController::supprimerVille'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/ville']], [], [], []],
    'creation_voiture' => [[], ['_controller' => 'App\\Controller\\ApiVoitureController::creationVoiture'], [], [['text', '/api/voiture']], [], [], []],
    'suppression_voiture' => [['id'], ['_controller' => 'App\\Controller\\ApiVoitureController::suppressionVoiture'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/voiture']], [], [], []],
    'liste_voitures' => [[], ['_controller' => 'App\\Controller\\ApiVoitureController::listeVoitures'], [], [['text', '/api/voitures']], [], [], []],
    'api_login' => [[], ['_controller' => 'App\\Controller\\SecurityController::login'], [], [['text', '/api/login_check']], [], [], []],
    'login_check' => [[], [], [], [['text', '/api/login_check']], [], [], []],
    'App\Controller\ApiAuthController::index' => [[], ['_controller' => 'App\\Controller\\ApiAuthController::index'], [], [['text', '/api/auth']], [], [], []],
    'App\Controller\ApiReservationController::creationReservation' => [[], ['_controller' => 'App\\Controller\\ApiReservationController::creationReservation'], [], [['text', '/api/reservation']], [], [], []],
    'App\Controller\ApiReservationController::confirmerReservation' => [['id'], ['_controller' => 'App\\Controller\\ApiReservationController::confirmerReservation'], [], [['text', '/confirmer'], ['variable', '/', '[^/]++', 'id', true], ['text', '/api/reservation']], [], [], []],
    'App\Controller\ApiReservationController::annulerReservation' => [['id'], ['_controller' => 'App\\Controller\\ApiReservationController::annulerReservation'], [], [['text', '/annuler'], ['variable', '/', '[^/]++', 'id', true], ['text', '/api/reservation']], [], [], []],
    'App\Controller\ApiReservationController::listeReservations' => [[], ['_controller' => 'App\\Controller\\ApiReservationController::listeReservations'], [], [['text', '/api/reservation']], [], [], []],
    'App\Controller\ApiReservationController::getReservation' => [['id'], ['_controller' => 'App\\Controller\\ApiReservationController::getReservation'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/reservation']], [], [], []],
    'App\Controller\ApiTrajetController::creationTrajet' => [[], ['_controller' => 'App\\Controller\\ApiTrajetController::creationTrajet'], [], [['text', '/api/trajet']], [], [], []],
    'App\Controller\ApiTrajetController::listeTrajets' => [[], ['_controller' => 'App\\Controller\\ApiTrajetController::listeTrajets'], [], [['text', '/api/trajets']], [], [], []],
    'App\Controller\ApiTrajetController::rechercheTrajets' => [[], ['_controller' => 'App\\Controller\\ApiTrajetController::rechercheTrajets'], [], [['text', '/api/trajets/recherche']], [], [], []],
    'App\Controller\ApiTrajetController::suppressionTrajet' => [['id'], ['_controller' => 'App\\Controller\\ApiTrajetController::suppressionTrajet'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/trajet']], [], [], []],
    'App\Controller\ApiTrajetController::modificationTrajet' => [['id'], ['_controller' => 'App\\Controller\\ApiTrajetController::modificationTrajet'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/trajet']], [], [], []],
    'App\Controller\ApiUtilisateurController::inscriptionUtilisateur' => [[], ['_controller' => 'App\\Controller\\ApiUtilisateurController::inscriptionUtilisateur'], [], [['text', '/api/utilisateur']], [], [], []],
    'App\Controller\ApiUtilisateurController::listeUtilisateurs' => [[], ['_controller' => 'App\\Controller\\ApiUtilisateurController::listeUtilisateurs'], [], [['text', '/api/utilisateurs']], [], [], []],
    'App\Controller\ApiUtilisateurController::listePassagers' => [['idtrajet'], ['_controller' => 'App\\Controller\\ApiUtilisateurController::listePassagers'], [], [['text', '/passagers'], ['variable', '/', '[^/]++', 'idtrajet', true], ['text', '/api/conducteur']], [], [], []],
    'App\Controller\ApiUtilisateurController::listeReservationUtilisateur' => [['id'], ['_controller' => 'App\\Controller\\ApiUtilisateurController::listeReservationUtilisateur'], [], [['text', '/reservation'], ['variable', '/', '[^/]++', 'id', true], ['text', '/api/utilisateur']], [], [], []],
    'App\Controller\ApiUtilisateurController::modificationUtilisateur' => [['id'], ['_controller' => 'App\\Controller\\ApiUtilisateurController::modificationUtilisateur'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/utilisateur']], [], [], []],
    'App\Controller\ApiUtilisateurController::suppressionUtilisateur' => [['id'], ['_controller' => 'App\\Controller\\ApiUtilisateurController::suppressionUtilisateur'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/utilisateur']], [], [], []],
    'App\Controller\ApiUtilisateurController::listeRoles' => [[], ['_controller' => 'App\\Controller\\ApiUtilisateurController::listeRoles'], [], [['text', '/api/roles']], [], [], []],
    'App\Controller\ApiVilleController::ajoutVille' => [[], ['_controller' => 'App\\Controller\\ApiVilleController::ajoutVille'], [], [['text', '/api/ville']], [], [], []],
    'App\Controller\ApiVilleController::listeVilles' => [[], ['_controller' => 'App\\Controller\\ApiVilleController::listeVilles'], [], [['text', '/api/villes']], [], [], []],
    'App\Controller\ApiVilleController::rechercheVille' => [[], ['_controller' => 'App\\Controller\\ApiVilleController::rechercheVille'], [], [['text', '/api/ville/recherche']], [], [], []],
    'App\Controller\ApiVilleController::supprimerVille' => [['id'], ['_controller' => 'App\\Controller\\ApiVilleController::supprimerVille'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/ville']], [], [], []],
    'App\Controller\ApiVoitureController::creationVoiture' => [[], ['_controller' => 'App\\Controller\\ApiVoitureController::creationVoiture'], [], [['text', '/api/voiture']], [], [], []],
    'App\Controller\ApiVoitureController::suppressionVoiture' => [['id'], ['_controller' => 'App\\Controller\\ApiVoitureController::suppressionVoiture'], [], [['variable', '/', '[^/]++', 'id', true], ['text', '/api/voiture']], [], [], []],
    'App\Controller\ApiVoitureController::listeVoitures' => [[], ['_controller' => 'App\\Controller\\ApiVoitureController::listeVoitures'], [], [['text', '/api/voitures']], [], [], []],
    'App\Controller\SecurityController::login' => [[], ['_controller' => 'App\\Controller\\SecurityController::login'], [], [['text', '/api/login_check']], [], [], []],
];
