<?php  
namespace projet3\Controleurs;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ControleurCorbeille
{

	// PAGE CORBEILLE (ADMINISTRATION)
	// return = (vue) administrationCorbeille.html.twig

	public function obtenirVue(Application $app)
	{
		// Récupère tous les épisodes, commentaires et signalements qui ont été supprimés

	    $episodes = $app['dao.episode']->episodesSupprimes();
	    $signalements = $app['dao.commentaire']->signalementsSupprimes();
	    $commentaires = $app['dao.commentaire']->commentairesSupprimes();

	 // Retour

    return $app['twig']->render('administrationCorbeille.html.twig', array(
    	'episodes' => $episodes,
    	'commentaires' => $commentaires,
    	'signalements' => $signalements,
    	));
	}


	// ACTION RESTAURATION D'UN ELEMENT
	// exit = (url) Redirection vers la page d'acceuil administration

	public function restaurer($id, $typeElement, Application $app)
	{
		switch ($typeElement) 
		{
	    	case 'Episode' :
	    		$restauration = $app['dao.episode']->restaurerObjet($id, $typeElement);
	    		break;

	    	case 'Commentaire' :
	    		$restauration = $app['dao.user']->restaurerObjet($id, $typeElement);
	    		break;
		}
		
		header('Location: http://alaska.thomassebert.fr/administration');
	  	exit();
	}

}