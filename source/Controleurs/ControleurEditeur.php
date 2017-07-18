<?php  
namespace projet3\Controleurs;

use Silex\Application;
use projet3\Domaine\EpisodeElement;
use projet3\Formulaires\FormulaireEditeur;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class ControleurEditeur
{

	// PAGE EDITEUR (ADMINISTRATION)
	// return = (vue) administrationAcceuil.html.twig
	
	public function obtenirVue($id, Request $request = null, Application $app)
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
	}

}