<?php  
namespace projet3\Controleurs;

use Silex\Application;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class ControleurErreur 
{

	
	// return = (vue) erreur.html.twig

	public function obtenirVue(\Exception $e, Request $request, $code, Application $app)
	{
		switch ($code) 
		{

	        case 404:
	            $message = "Cette page n'existe pas!";
	            break;

	        default:
	        
	            $message = "Désolé, il semblerait que quelque chose se soit très mal passé... ";
	    }

    	return $app['twig']->render('erreur.html.twig', array(
    	'message' => $message,
    	'code' => $code
    	));
    }

}