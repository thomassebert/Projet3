<?php

namespace projet3\DAO;

use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use projet3\Domaine\UtilisateurElement;
use Silex\Application;


class UtilisateurDAO extends DAO implements UserProviderInterface
{

	//RECUPERER UN UTILISATEUR PAR SON ID
	// parametre = (int) ID de l'utilisateur
	// return = (array) Tableau d'objets UtilisateurElement

	public function obtenirUnUtilisateurParId($idUtilisateur)
    {
        $requeteSql = $this->_bdd->prepare('SELECT * FROM utilisateurs WHERE ID = ? AND corbeille = "non"');
        $utilisateur = $this->obtenirObjet($requeteSql, 'UtilisateurElement', $idUtilisateur);
        return $utilisateur;
    }

    public function modifierMotDePasse($nouveauMotDePasse, $nouveauSel, $id)
    {
            $requeteSql = $this->_bdd->prepare('UPDATE utilisateurs SET password = :nouveauMotDePasse, salt = :nouveauSel WHERE ID = :id ');
            $requeteSql->execute(array(
                'nouveauMotDePasse' => $nouveauMotDePasse,
                'nouveauSel' => $nouveauSel,
                'id' => $id
                ));
    }

    /**
     * {@inheritDoc}
     */
    public function loadUserByUsername($username)
    {
        $username = (string) $username;

        $requeteSql = $this->_bdd->prepare('SELECT * FROM utilisateurs WHERE username = ?');
        $requeteSql->execute(array($username));
        $resultatsRequete = $requeteSql;
        foreach ($resultatsRequete as $donneesObjet) 
        {
            $objet = new UtilisateurElement($donneesObjet);
        }
        
        return $objet;
        
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
