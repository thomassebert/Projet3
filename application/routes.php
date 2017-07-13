<?php

use projet3\Domaine\CommentaireElement;
use projet3\Domaine\EpisodeElement;
use projet3\Domaine\UtilisateurElement;
use projet3\Formulaires\FormulaireCommentaire;
use projet3\Formulaires\FormulaireEditeur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

// PAGE ACCEUIL
// return = (vue) index.html.twig

$app->get('/', function () use ($app) 
{
	// Récupère tous les épisodes

    	$episodes = $app['dao.episode']->obtenirEpisodes();

    // Retour

    return $app['twig']->render('index.html.twig', array(
    	'episodes' => $episodes
    	));
});


// PAGE EPISODE
// return = (vue) episode.html.twig

$app->match('/episode/{id}', function ($id, Request $request) use ($app) 
{
    // Récupère l'épisode demandé

		$episode = $app['dao.episode']->obtenirUnEpisodeParId($id);
	
	// Si cet épisode n'est pas encore publié (brouillon)
	// exit = (url) Redirection vers la page d'acceuil

		if($episode->etat() != 'publié')
		{
			header('Location: http://alaska.thomassebert.fr/');
	  		exit();
		}

	// On incrémente le nombre de vues de l'épisode

		$compteur = $app['dao.episode']->compteurVues($id);

	// Création du formulaire d'ajout de commentaire (et de signalement)

		$commentaire = new CommentaireElement([]);
		$formulaire = $app['form.factory']->create(FormulaireCommentaire::class, $commentaire);
		$formulaire->handleRequest($request);

		// Si des données ont été entrées et sont valides
		// Ajout du commentaire en BDD

			if ($formulaire->isSubmitted() && $formulaire->isValid()) 
			{
	            $app['dao.commentaire']->creerCommentaire($commentaire, $id);
	            $alerte = "Votre commentaire à bien été publié";
	    	}

    	$vueFormulaire = $formulaire->createView();

    // Récupère et compte tous les commentaires de l'épisode

    	$commentaires = $app['dao.commentaire']->obtenirCommentairesDunEpisode($id);
    	$nombreCommentaires = 0;
    	foreach ($commentaires as $commentaire) 
    	{
    		$nombreCommentaires += 1; 
    	}

    // Retour

    return $app['twig']->render('episode.html.twig', array(
    	'episode' => $episode, 
    	'commentaires' => $commentaires,
    	'nbCommentaire' => $nombreCommentaires,
    	'alerte' => $alerte,
    	'formulaireCommentaire' => $vueFormulaire
    	));
});


// PAGE CONNEXION ADMINISTRATION
// return = (vue) login.html.twig
// Géré par SecurityServiceProvider

$app->get('/login', function(Request $request) use ($app) 
{
    return $app['twig']->render('login.html.twig', array(
        'error'         => $app['security.last_error']($request),
        'last_username' => $app['session']->get('_security.last_username'),
    ));
})->bind('login');


// PAGE ACCEUIL ADMINISTRATION
// return = (vue) administrationAcceuil.html.twig

$app->get('/administration', function () use ($app) 
{
	// Récupère tous les épisodes, commentaires et signalements

	    $episodes = $app['dao.episode']->obtenirEpisodes();
	    $signalements = $app['dao.commentaire']->obtenirSignalements();
	    $commentaires = $app['dao.commentaire']->obtenirCommentaires();

	// Compte le nombre de signalements et sépare les signalements des commentaires
	// $signalements est un tableau d'objets Commentaire, un sur deux est un signalement, l'autre le cmmentaire signalé

	    $nbSignalements = 0;

	    $signalement = array();
	    $commentaireSignale = array(); 

	    foreach ($signalements as $key => $objet) 
	    {
	    	if ($key%2 == 0) 
	    	{
	    		$signalement[] = $objet;
	    		$nbSignalements += 1; 
	    	}
	    	else
	    	{
	    		$commentaireSignale[] = $objet;
	    	}
	    }

	 // Retour

    return $app['twig']->render('administrationAcceuil.html.twig', array(
    	'episodes' => $episodes,
    	'commentaires' => $commentaires,
    	'nbSignalements' => $nbSignalements,
    	'signalements' => $signalement,
    	'commentaireSignale' => $commentaireSignale
    	));
});

// ACTION SUPPRESSION D'UN ELEMENT
// exit = (url) Redirection vers la page d'acceuil administration

$app->match('/administration/supprimer/{id}/{typeElement}', function($id, $typeElement) use ($app)
{
	switch ($typeElement) 
	{
		case 'Signalement' :
			$suppression = $app['dao.commentaire']->suppressionObjet($id, $typeElement);
    		break;

		case 'SignalementSeul' :
    		$suppression = $app['dao.commentaire']->suppressionObjet($id, $typeElement);
    		break;

    	case 'Episode' :
    		$suppression = $app['dao.episode']->suppressionObjet($id, $typeElement);
    		break;

    	case 'Utilisateur' :
    		$suppression = $app['dao.user']->suppressionObjet($id, $typeElement);
    		break;
	}
		
	header('Location: http://alaska.thomassebert.fr/administration');
  	exit();

});


// PAGE ADMINISTRATION EDITEUR
// return = (vue) administrationAcceuil.html.twig

$app->match('/administration/editer/{id}', function ($id, Request $request) use ($app) 
{
	// Choix mise à jour d'un épisode ou création d'un nouveau

		if (! $id == 0) {
			$episode = $app['dao.episode']->obtenirUnEpisodeParId($id);
	   		$episode->setImage(new File('assets/images/'.$episode->image()));
		}

		else
		{
			$episode = new EpisodeElement([]);
		}

	// Création du formulaire d'édition

		$formulaire = $app['form.factory']->create(FormulaireEditeur::class, $episode);
		$formulaire->handleRequest($request);

		// Si des données ont été entrées et sont valides
		// Stockage de l'image -> projet3/web/assets/images/
		// Mise à jour ou création de l'épisode en BDD
		// exit = (url) Redirection vers la page d'acceuil administration

		if ($formulaire->isSubmitted() && $formulaire->isValid() && $episode->titre() != null && $episode->contenu() != null && $episode->image() != null && $episode->auteur() != null && $episode->etat() != null) 
		{
			// Récupération du fichier
	        $donnees = $request->files->get($formulaire->getName());
	        $fichier = $donnees['image'];

	        // Création d'un nom unique
	        $nomFichier = md5(uniqid()).'.'.$fichier->guessExtension();

	        // Déplacement vers le dossier images
	        $fichier->move('assets/images', $nomFichier);

	        // Modification de l'attribut image: remplacement de l'image par son nom
	        $episode->setImage($nomFichier);

			if ((!$id == 0) && ($episode->etat() == 'publié')) 
			{
				$app['dao.episode']->miseAJourEpisode($id, $episode);
			}

			else
			{
				$app['dao.episode']->creerEpisode($episode);
			}

			header('Location: http://alaska.thomassebert.fr/administration');
			exit();
		}

	    else
	    {
		    $vueFormulaire = $formulaire->createView();
			
		// Return 

		return $app['twig']->render('administrationEditeur.html.twig', array(
		    'episode' => $episode,
		    'id' => $id,
		    'formulaireEditeur' => $vueFormulaire
		    ));
	 	}
});




