<?php  
namespace projet3\Controleurs;

use Silex\Application;
use Symfony\Component\HttpFoundation\Request;

class ControleurLogin
{

	// PAGE CONNEXION ADMINISTRATION
	// return = (vue) login.html.twig
	// Géré par SecurityServiceProvider
	
	public function obtenirVue(Request $request = null, Application $app)
	{
		return $app['twig']->render('login.html.twig', array(
	        'error'         => $app['security.last_error']($request),
	        'last_username' => $app['session']->get('_security.last_username'),
	    ));
	}

}
