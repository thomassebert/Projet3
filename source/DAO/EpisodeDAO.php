<?php
namespace projet3\DAO;

use projet3\Domaine\EpisodeElement; 

class EpisodeDAO extends DAO
{
    
    //RECUPERER TOUS LES EPISODES 
    // return = (array) Tableau d'objets EpisodesElement

    public function obtenirEpisodes()
    {
        $requeteSql = $this->_bdd->prepare('SELECT * FROM episodes_publies WHERE corbeille = "non" ORDER BY date_publication DESC');
        $episodes = $this->obtenirObjet($requeteSql, 'EpisodeElement');
        return $episodes;
    }

    public function episodesSupprimes()
    {
        $requeteSql = $this->_bdd->prepare('SELECT * FROM episodes_publies WHERE corbeille = "oui" ORDER BY date_publication DESC');
        $episodes = $this->obtenirObjet($requeteSql, 'EpisodeElement');
        return $episodes;
    }


    //RECUPERER UN EPISODE PAR SON ID
    // parametre = (int) ID de l'épisode
    // return = (array) Tableau contenant l'objet EpisodeElement

    public function obtenirUnEpisodeParId($idEpisode)
    {
        $idEpisode = (int) $idEpisode;
        $requeteSql = $this->_bdd->prepare('SELECT * FROM episodes_publies WHERE ID = ? AND corbeille = "non"');
        $episodes = $this->obtenirObjet($requeteSql, 'EpisodeElement', $idEpisode);
        $episode = $episodes[$idEpisode];
        return $episode;
    } 


    //CREER UN EPISODE EN BDD
    // parametre = (EpisodeElement) objet Episode à enregistrer

    public function creerEpisode(EpisodeElement $episode)
    {
        $requeteSql = $this->_bdd->prepare('INSERT INTO episodes_publies(titre, date_publication, nombre_vues, contenu, etat, auteur, image) VALUES(:titre, :date_publication, :nombre_vues, :contenu, :etat, :auteur, :image)');
        $requeteSql->execute(array(
             'titre' => $episode->titre(),
             'date_publication' => date("Y-m-d H:i:s"),
             'nombre_vues' => 0,
             'contenu' => $episode->contenu(),
             'etat' => $episode->etat(),
             'auteur' => $episode->auteur(),
             'image' => $episode->image()
            ));
    }


    //MISE A JOUR DES DONNEES D'UN EPISODE
    // parametre1 = (int) ID de l'épisode à mettre à jour
    // parametre2 = (EpisodeElement) objet Episode à enregistrer

    public function miseAJourEpisode($id, EpisodeElement $episode)
    {
        $id = (int) $id;
        $requeteSql = $this->_bdd->prepare('UPDATE episodes_publies SET titre=:titre, nombre_vues=:nombre_vues, contenu=:contenu, etat=:etat, auteur=:auteur WHERE ID = :id');
        $requeteSql->execute(array(
             'titre' => $episode->titre(),
             'nombre_vues' => $episode->nombre_vues(),
             'contenu' => $episode->contenu(),
             'etat' => $episode->etat(),
             'auteur' => $episode->auteur(),
             'id' => $id
            ));
        if(!is_null($episode->image()))
        {
            $requeteSql = $this->_bdd->prepare('UPDATE episodes_publies SET image=:image WHERE ID = :id');
            $requeteSql->execute(array(
                 'image' => $episode->image(),
                 'id' => $id
                 ));
        }
    }

    //COMPTEUR DE VUES D'UN EPISODE
    // parametre = (int) ID de l'épisode

    public function compteurVues($id)
    {
        $id = (int) $id;
        $requeteSql = $this->_bdd->prepare('UPDATE episodes_publies SET nombre_vues=nombre_vues+1 WHERE ID = ?');
        $requeteSql->execute(array($id));
    }
  
}
