<?php  
namespace projet3\Controleurs;

use Silex\Application;
use projet3\Domaine\CommentaireElement;
use projet3\Formulaires\FormulaireCommentaire;
use Symfony\Component\HttpFoundation\Request;

class ControleurEpisode 
{

	// PAGE EPISODE
	// return = (vue) episode.html.twig

	public function obtenirVue($id, Request $request = null, Application $app)
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
	            $request = null;
	            header('Location: http://alaska.thomassebert.fr/episode/'.$id);
	  			exit();
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
	}

}