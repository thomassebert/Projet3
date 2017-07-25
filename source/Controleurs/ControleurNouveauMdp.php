<?php  
namespace projet3\Controleurs;

use Silex\Application;

class ControleurNouveauMdp
{

	// PAGE MODIFICATION MOT DE PASSE
	// return = (vue) administrationNouveauMdp.html.twig
	
	public function obtenirVue(Application $app, $id, $post)
	{
	if($post == 'oui')
	{
		if(isset($_POST['mdp1']) && isset($_POST['mdp2']))
		{
			$mdp1 = htmlspecialchars($_POST['mdp1']);
			$mdp2 = htmlspecialchars($_POST['mdp2']);
			if ($mdp1 == $mdp2) 
			{
				$salt = sha1($nouveauMotDePasse);
                $encoder = $app['security.encoder.bcrypt'];
                $password = $encoder->encodePassword($mdp1, $salt);
				$app['dao.user']->modifierMotDePasse($password, $salt, $id);
				return $app->redirect('http://alaska.thomassebert.fr/logout');
	  			
			}
			else
			{
				$message = 'Les deux valeurs doivent être identiques!';
			}
		}
	}

		return $app['twig']->render('administrationNouveauMdp.html.twig', array(
	        'message' => $message,
	    ));
	}

}