<?php  
namespace projet3\Controleurs;

use Silex\Application;

class ControleurAccueil 
{

	
	// return = (vue) index.html.twig

	public function obtenirVue(Application $app)
	{
		// Récupère tous les épisodes

    	$episodes = $app['dao.episode']->obtenirEpisodes();

    	// Retour

    return $app['twig']->render('index.html.twig', array(
    	'episodes' => $episodes
    	));
	}

}