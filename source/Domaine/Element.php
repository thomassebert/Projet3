<?php 
namespace projet3\Domaine;

abstract class Element
{

	//CONSTRUCTEUR
	// parametre = (array) Tableau contenant les noms et valeurs d'attributs à hydrater 
	
	final public function __construct(array $donnees)
	{
		$this->hydrate($donnees);
	}


	//HYDRATATION VIA LES SETTERS
	// parametre = (array) Tableau contenant les noms et valeurs d'attributs à hydrater

	final public function hydrate(array $donnees)
	{
	    foreach ($donnees as $key => $value)
	    {
	    	$method = 'set'.ucfirst($key);
	      	if (method_exists($this, $method))
	      	{
	       		$this->$method($value);
	      	}
	    }
	}

}