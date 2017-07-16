<?php 
namespace projet3\Domaine;

class EpisodeElement extends Element
{

	//ATTRIBUTS
	
	private $_id;
	private $_titre;
	private $_date_publication;
	private $_nombre_vues;
	private $_contenu;
	private $_etat;
	private $_auteur;
	private $_image;
	private $_corbeille;

	//GETTERS format attribut()

	public function id()
	{
		return $this->_id;
	}

	public function titre()
	{
		return $this->_titre;
	}

	public function date_publication()
	{
		return $this->_date_publication;
	}

	public function nombre_vues()
	{
		return $this->_nombre_vues;
	}

	public function contenu()
	{
		return $this->_contenu;
	}

	public function etat()
	{
		return $this->_etat;
	}

	public function auteur()
	{
		return $this->_auteur;
	}

	public function image()
	{
		return $this->_image;
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

 	public function setTitre($titre)
    {
    	$titre = (string) $titre;
	    $this->_titre = $titre;
 	}

 	public function setDate_publication($date_publication)
 	{
 		$date_publication = (string) $date_publication;
 		$format = 'Y-m-d H:i:s';
		$date = \DateTime::createFromFormat($format, $date_publication);
		$date_publication = $date->format('d-m-Y');
		$this->_date_publication = $date_publication;
 	}

 	public function setNombre_vues($nombre_vues)
 	{
 		$nombre_vues = (int) $nombre_vues;
 		if($nombre_vues >= 0)
 		{
 			$this->_nombre_vues = $nombre_vues;
 		}
 	}

 	public function setContenu($contenu)
 	{
 		$contenu = (string) $contenu;
 		$this->_contenu = $contenu; 
 	}

 	public function setEtat($etat)
 	{
 		$etat = (string) $etat;
 		$this->_etat = $etat; 
 	}

 	public function setAuteur($auteur)
 	{
 		$auteur = (string) $auteur;
 		$this->_auteur = $auteur; 
 	}

 	public function setImage($image)
 	{
 		$image = $image;
 		$this->_image = $image; 
 	}

}