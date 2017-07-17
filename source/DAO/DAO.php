<?php
namespace projet3\DAO;

use Doctrine\DBAL\Connection;
use projet3\Domaine\CommentaireElement;
use projet3\Domaine\EpisodeElement;
use projet3\Domaine\UtilisateurElement;

abstract class DAO
{

	//ATTRIBUT
	
	protected $_bdd;
	

    // CONSTRUCTEUR 
    // parametre = (object Connexion) \Doctrine\DBAL\Connection 

    public function __construct(Connection $bdd) 
    {
        $this->setBdd($bdd); 
    }


    //SETTER 
    // parametre = (object Connexion) \Doctrine\DBAL\Connection 

    public function setBdd(Connection $bdd)
    {
        $this->_bdd = $bdd;
    }


    //RECUPERATION DONNEES 
    // parametre 1 = (string) Requête SQL
    // parametre 2 = (string) Type d'objet 
    // retour = (array) Tableau d'objets 

    public function obtenirObjet($requeteSql, $typeObjet) 
    {
        $resultatsRequete = $this->_bdd->fetchAll($requeteSql);

        $tableauObjets = array();

        foreach ($resultatsRequete as $donneesObjet) 
        {
            $idObjet = $donneesObjet['ID'];
            $tableauObjets[$idObjet] = $this->constructionObjet($donneesObjet, $typeObjet);
        }
        return $tableauObjets;
    }


    // CONSTRUCTION D'UN OBJET 
    // parametre 1 = (array) Tableau contenant les données de l'objet à construire
    // parametre 2 = (string) Type d'objet
    // retour = (object) Objet créé

    private function constructionObjet(array $donneesObjet, $typeObjet) 
    {
    	switch ($typeObjet)
    	{
    		case 'CommentaireElement' :
    			$objet = new CommentaireElement($donneesObjet);
    			break;

    		case 'EpisodeElement' :
    			$objet = new EpisodeElement($donneesObjet);
    			break;

    		case 'UtilisateurElement' :
    			$objet = new UtilisateurElement($donneesObjet);
    			break;

    	}
        
        return $objet;
    }


    // SUPPRESSION D'UN OBJET 
    // parametre 1 = (int) ID de l'objet à supprimer
    // parametre 2 = (string) Type de l'objet

    public function suppressionObjet($idObjet, $typeObjet)
    {
    	switch ($typeObjet)
    	{
    		case 'Signalement' :

    			$reponse = $this->_bdd->query("SELECT ID_commentaire_reponse FROM commentaires WHERE ID = ".$idObjet);
    			$idCommentaire = $reponse->fetch();
    			$suppressionCommentaire = $this->_bdd->exec("UPDATE commentaires SET corbeille = 'oui' WHERE ID = ".$idCommentaire['ID_commentaire_reponse']);
    			$suppressionSignalement = $this->_bdd->exec("UPDATE commentaires SET corbeille = 'oui' WHERE ID = ".$idObjet);

    			break;

    		case 'SignalementSeul' :

    			$suppressionSignalement = $this->_bdd->exec("UPDATE commentaires SET corbeille = 'oui' WHERE ID = ".$idObjet);

    			break;

    		case 'Episode' :

    			$suppressionEpisodes = $this->_bdd->exec("UPDATE episodes_publies SET corbeille = 'oui' WHERE ID = ".$idObjet);
    			$suppressionCommentaires = $this->_bdd->exec("UPDATE commentaires SET corbeille = 'oui' WHERE ID_episode = ".$idObjet);
   
    			break;

    		case 'Utilisateur' :

    			$suppressionUtilisateur = $this->_bdd->exec("UPDATE utilisateurs SET corbeille = 'oui' WHERE ID = ".$idObjet);
    			
    			break;
    	}
    }

    // RESTAURATION D'UN OBJET SUPPRIME
    // parametre 1 = (int) ID de l'objet à restaurer
    // parametre 2 = (string) Type de l'objet

    public function restaurerObjet($idObjet, $typeObjet)
    {
        switch ($typeObjet)
        {
            case 'Episode' :

                $restaurerEpisode = $this->_bdd->exec("UPDATE episodes_publies SET corbeille = 'non' WHERE ID = ".$idObjet);

   
                break;

            case 'Commentaire' :

                $restaurerCommentaire = $this->_bdd->exec("UPDATE commentaires SET corbeille = 'non' WHERE ID_episode = ".$idObjet);
                
                break;
        }
    }


}