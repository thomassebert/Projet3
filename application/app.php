<?php

use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;

// Register global error and exception handlers
ErrorHandler::register();
ExceptionHandler::register();

// Register service providers.
$app->register(new Silex\Provider\DoctrineServiceProvider());
$app->register(new Silex\Provider\TwigServiceProvider(), array(
    'twig.path' => __DIR__.'/../vues',
));
$app->register(new Silex\Provider\AssetServiceProvider(), array(
    'assets.version' => 'v1'
));
$app->register(new Silex\Provider\FormServiceProvider());
$app->register(new Silex\Provider\LocaleServiceProvider());
$app->register(new Silex\Provider\TranslationServiceProvider());
$app->register(new Silex\Provider\SessionServiceProvider());
$app->register(new Silex\Provider\ValidatorServiceProvider());


$app->register(new Silex\Provider\SecurityServiceProvider(), array(
    'security.firewalls' => array(
        'secured' => array(
            'pattern' => '^/',
            'anonymous' => true,
            'logout' => true,
            'form' => array('login_path' => '/login', 'check_path' => '/login_check'),
            'logout' => array('logout_path' => '/logout', 'invalidate_session' => true),
            'users' => function () use ($app) {
                return new projet3\DAO\UtilisateurDAO($app['db']);
            },
        ),
    ),
     'security.role_hierarchy' => array(
      'ROLE_ADMIN' => array('ROLE_USER'),
      'ROLE_VISITEUR' => array('ROLE_ADMIN'),
    ),
    'security.access_rules' => array(
        array('^/administration', 'ROLE_ADMIN', 'ROLE_VISITEUR'),
    ),
));


// Register services.
$app['dao.episode'] = function ($app) {
    return new projet3\DAO\EpisodeDAO($app['db']);
};
$app['dao.commentaire'] = function ($app) {
    return new projet3\DAO\CommentaireDAO($app['db']);
};
$app['dao.user'] = function ($app) {
    return new projet3\DAO\UtilisateurDAO($app['db']);
};
$app['twig'] = $app->extend('twig', function(Twig_Environment $twig, $app) {
    $twig->addExtension(new Twig_Extensions_Extension_Text());
    return $twig;
});
