<?php 
namespace projet3\Domaine;

class CommentaireElement extends Element
{

	//ATTRIBUTS

	private $_id;
	private $_id_episode;
	private $_auteur_commentaire;
	private $_date_publication_commentaire;
	private $_contenu_commentaire;
	private $_signalement;
	private $_reponse;
	private $_niveau_commentaire;
	private $_id_commentaire_reponse;
	private $_email;
	private $_corbeille;


	//METHODES MAGIQUES


	public function __toString()
	{
		$id = $this->auteur_commentaire();
		return $id;

	}

	public function __get($attribut)
	{
		$getter = '_'.$attribut;
		$reponse = $this->$getter;
		return $reponse;
	}

	public function __set($attribut, $valeur)
	{
		$methode = 'set'.ucfirst($attribut);
	      	if (method_exists($this, $methode))
	      	{
	       		$this->$methode($valeur);
	      	}
	}


	//GETTERS format attribut()


	public function id()
	{
		return $this->_id;
	}

	public function id_episode()
	{
		return $this->_id_episode;
	}

	public function auteur_commentaire()
	{
		return $this->_auteur_commentaire;
	}

	public function date_publication_commentaire()
	{
		return $this->_date_publication_commentaire;
	}

	public function contenu_commentaire()
	{
		return $this->_contenu_commentaire;
	}

	public function signalement()
	{
		return $this->_signalement;
	}

	public function reponse()
	{
		return $this->_reponse;
	}

	public function niveau_commentaire()
	{
		return $this->_niveau_commentaire;
	}

	public function id_commentaire_reponse()
	{
		return $this->_id_commentaire_reponse;
	}

	public function email()
	{
		return $this->_email;
	}

	public function corbeille()
	{
		return $this->_corbeille;
	}


	//SETTERS format setAttribut($valeur)


	public function setId($id)
    {
    	$id = (int) $id;
    
    	if ($id >= 0)
	    {
	    	$this->_id = $id;
	    }
 	}

 	public function setId_episode($id_episode)
    {
    	$id_episode = (int) $id_episode;
    
    	if ($id_episode >= 0)
	    {
	    	$this->_id_episode = $id_episode;
	    }
 	}

 	public function setAuteur_commentaire($auteur_commentaire)
 	{
 		$auteur_commentaire = (string) $auteur_commentaire;
 		$this->_auteur_commentaire = $auteur_commentaire; 
 	}

 	public function setDate_publication_commentaire($date_publication_commentaire)
 	{
 		$date_publication_commentaire = (string) $date_publication_commentaire;
 		$format = 'Y-m-d H:i:s';
		$date = \DateTime::createFromFormat($format, $date_publication_commentaire);
		$date_publication_commentaire = $date->format('d-m-Y à H:i');
		$this->_date_publication_commentaire = $date_publication_commentaire;
 	}

 	public function setContenu_commentaire($contenu_commentaire)
 	{
 		$contenu_commentaire = (string) $contenu_commentaire;
 		$this->_contenu_commentaire = $contenu_commentaire; 
 	}

 	public function setSignalement($signalement)
 	{
 		$signalement = (string) $signalement;
 		$this->_signalement = $signalement; 
 	}

 	public function setReponse($reponse)
 	{
 		$reponse = (string) $reponse;
 		$this->_reponse = $reponse; 
 	}

 	public function setNiveau_commentaire($niveau_commentaire)
    {
    	$niveau_commentaire = (int) $niveau_commentaire;
    
    	if ($niveau_commentaire >= 0)
	    {
	    	$this->_niveau_commentaire = $niveau_commentaire;
	    }
 	}

 	public function setId_commentaire_reponse($id_commentaire_reponse)
    {
    	$id_commentaire_reponse = (int) $id_commentaire_reponse;
    
    	if ($id_commentaire_reponse >= 0)
	    {
	    	$this->_id_commentaire_reponse = $id_commentaire_reponse;
	    }
 	}

 	public function setEmail($email)
 	{
 		$email = (string) $email;
 		$this->_email = $email; 
 	}


}