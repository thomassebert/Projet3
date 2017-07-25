<?php
namespace projet3\DAO;

use projet3\Domaine\CommentaireElement; 

class CommentaireDAO extends DAO
{


	//RECUPERER TOUS LES COMMENTAIRES, TOUT EPISODE CONFONDU
	// return = (array) Tableau d'objets CommentaireElement

	public function obtenirCommentaires() 
	{
		$requeteSql = 'SELECT * FROM commentaires WHERE signalement = "non" AND corbeille = "non" ORDER BY date_publication_commentaire';
		$commentaires = $this->obtenirObjet($requeteSql, 'CommentaireElement');
		return $commentaires;
	}

	public function commentairesSupprimes() 
	{
		$requeteSql = 'SELECT * FROM commentaires WHERE signalement = "non" AND corbeille = "oui" ORDER BY date_publication_commentaire';
		$commentaires = $this->obtenirObjet($requeteSql, 'CommentaireElement');
		return $commentaires;
	}

	public function signalementsSupprimes() 
	{
		$requeteSql = 'SELECT * FROM commentaires WHERE signalement = "oui" AND corbeille = "oui" ORDER BY date_publication_commentaire';
		$commentaires = $this->obtenirObjet($requeteSql, 'CommentaireElement');
		return $commentaires;
	}


	//RECUPERER TOUS LES COMMENTAIRES LIES A UN EPISODE 
	// parametre = (int) ID de l'épisode
	// return = (array) Tableau d'objets CommentaireElement

	public function obtenirCommentairesDunEpisode($idEpisode) 
	{
		$idEpisode = (int) $idEpisode;
		$requeteSql = $this->_bdd->prepare('SELECT * FROM commentaires WHERE ID_episode = ? AND signalement = "non" ORDER BY date_publication_commentaire');
		$commentaires = $this->obtenirObjet($requeteSql, 'CommentaireElement', $idEpisode);
		return $commentaires;
	}


	//RECUPERER UN EPISODE PAR SON ID
	// parametre = (int) ID du commentaire
	// return = (array) Tableau d'objets CommentaireElement

	public function obtenirCommentaireParId($idCommentaire) 
	{
		$idCommentaire = (int) $idCommentaire;
		$requeteSql = $this->_bdd->prepare('SELECT * FROM commentaires WHERE ID = ? AND corbeille = "non"');
		$commentaire = $this->obtenirObjet($requeteSql, 'CommentaireElement', $idCommentaire);
		return $commentaire;
	}


	//RECUPERER TOUS LES SIGNALEMENTS
	// return = (array(array)) Tableau de tableaux contenant chaque couple signalement / commentaire signalé

	public function obtenirSignalements() 
	{
		$requeteSql = 'SELECT * FROM commentaires WHERE signalement = "oui" AND corbeille = "non" ORDER BY date_publication_commentaire';
		$signalements = $this->obtenirObjet($requeteSql, 'CommentaireElement');

		$reponse = array();

		foreach ($signalements as $signalement) 
		{
			$commentaire = $this->obtenirCommentaireParId($signalement->id_commentaire_reponse());
			foreach ($commentaire as $key => $objet) 
			{
        		$commentaireSignale = $objet;
        	}
        	$couple[] = $signalement;
			$couple[] = $commentaireSignale;
		}

		$reponse[] = $couple;

		foreach ($reponse as $key => $value) 
		{
			$signal = $value;
		}
		
		return $value;
	}


	//CREER UN COMMENTAIRE EN BDD
	// parametre1 = (CommentaireElement) objet Commentaire à enregistrer
	// parametre2 = (int) ID de l'épisode commenté

	public function creerCommentaire(CommentaireElement $commentaire, $idEpisode)
	{
		//Si le commentaire est une réponse, on change l'état de la valeur "réponse" du commentaire auquel on répond
		if (!is_null($commentaire->id_commentaire_reponse)) 
		{
			$update = $this->_bdd->prepare("UPDATE commentaires SET reponse='oui' WHERE id= :id");
			$update->execute(array('id' => $commentaire->id_commentaire_reponse()));
		}

		//On insère le commentaire en BDD
		$requeteSql = $this->_bdd->prepare('INSERT INTO commentaires(ID_episode, auteur_commentaire, date_publication_commentaire, contenu_commentaire, signalement, reponse, niveau_commentaire, ID_commentaire_reponse, email) VALUES(:ID_episode, :auteur_commentaire, :date_publication_commentaire, :contenu_commentaire, :signalement, :reponse, :niveau_commentaire, :ID_commentaire_reponse, :email)');
		$requeteSql->execute(array(
			'ID_episode'=>$idEpisode,
			'auteur_commentaire'=>$commentaire->auteur_commentaire(), 
			'date_publication_commentaire'=>date("Y-m-d H:i:s"), 
			'contenu_commentaire'=>$commentaire->contenu_commentaire(), 
			'signalement'=>$commentaire->signalement(), 
			'reponse'=>"non", 
			'niveau_commentaire'=>$commentaire->niveau_commentaire(), 
			'ID_commentaire_reponse'=>$commentaire->id_commentaire_reponse(), 
			'email'=>$commentaire->email()
			));
	}

}

