<?php

namespace projet3\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use projet3\Domaine\UtilisateurElement;

class UtilisateurDAO extends DAO implements UserProviderInterface
{

	//RECUPERER UN UTILISATEUR PAR SON ID
	// parametre = (int) ID de l'utilisateur
	// return = (array) Tableau d'objets UtilisateurElement

	public function obtenirUnUtilisateurParId($idUtilisateur)
    {
        $requeteSql = 'SELECT * FROM utilisateurs WHERE ID ='.$idUtilisateur;
        $utilisateur = $this->obtenirObjet($requeteSql, 'UtilisateurElement');
        return $utilisateur;
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
    	$username = (string) $username;
        $requeteSql = 'SELECT * FROM utilisateurs WHERE username = '.$username;
        $utilisateurs = $this->obtenirObjet($requeteSql, 'UtilisateurElement');
        foreach ($utilisateurs as $key => $value) {
        	$utilisateur = $value;
        }
        
        return $utilisateur;
        
    }  

    /**
     * {@inheritDoc}
     */
    public function refreshUser(UserInterface $user)
    {
        $class = get_class($user);
        if (!$this->supportsClass($class)) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', $class));
        }
        return $this->loadUserByUsername($user->getUsername());
    }

    /**
     * {@inheritDoc}
     */
    public function supportsClass($class)
    {
        return 'projet3\Domaine\UtilisateurElement' === $class;
    }

}