<?php

// PAGE ACCEUIL
// return = (vue) index.html.twig

$app->get('/', "projet3\Controleurs\ControleurAccueil::obtenirVue" );


// PAGE EPISODE
// return = (vue) episode.html.twig

$app->match('/episode/{id}', "projet3\Controleurs\ControleurEpisode::obtenirVue" );


// PAGE CONNEXION ADMINISTRATION
// return = (vue) login.html.twig

$app->get('/login', "projet3\Controleurs\ControleurLogin::obtenirVue" )->bind('login');


// PAGE ACCEUIL ADMINISTRATION
// return = (vue) administrationAcceuil.html.twig

$app->get('/administration', "projet3\Controleurs\ControleurAccueilAdministration::obtenirVue" );

// ACTION SUPPRESSION D'UN ELEMENT
// exit = (url) Redirection vers la page d'acceuil administration

$app->match('/administration/supprimer/{id}/{typeElement}', "projet3\Controleurs\ControleurAccueilAdministration::supprimer" );


// PAGE EDITEUR (ADMINISTRATION)
// return = (vue) administrationAcceuil.html.twig

$app->match('/administration/editer/{id}', "projet3\Controleurs\ControleurEditeur::obtenirVue" );


// PAGE CORBEILLE (ADMINISTRATION)
// return = (vue) administrationCorbeille.html.twig

$app->get('/administration/corbeille', "projet3\Controleurs\ControleurCorbeille::obtenirVue" );

// ACTION RESTAURATION D'UN ELEMENT
// exit = (url) Redirection vers la page d'acceuil administration

$app->match('/administration/restaurer/{id}/{typeElement}', "projet3\Controleurs\ControleurCorbeille::restaurer" );



