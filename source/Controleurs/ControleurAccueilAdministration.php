<?php  
namespace projet3\Controleurs;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ControleurAccueilAdministration
{
	// PAGE ACCEUIL ADMINISTRATION
	// return = (vue) administrationAcceuil.html.twig
	
	public function obtenirVue(Application $app)
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
	}

	// ACTION SUPPRESSION D'UN ELEMENT
	// exit = (url) Redirection vers la page d'acceuil administration
	
	public function supprimer($id, $typeElement, Application $app)
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
	}

}