<?php
namespace projet3\DAO;

use projet3\Domaine\EpisodeElement; 

class EpisodeDAO extends DAO
{
    
    //RECUPERER TOUS LES EPISODES 
    // return = (array) Tableau d'objets EpisodesElement

    public function obtenirEpisodes()
    {
        $requeteSql = 'SELECT * FROM episodes_publies WHERE corbeille = "non" ORDER BY date_publication DESC';
        $episodes = $this->obtenirObjet($requeteSql, 'EpisodeElement');
        return $episodes;
    }


    //RECUPERER UN EPISODE PAR SON ID
    // parametre = (int) ID de l'épisode
    // return = (array) Tableau contenant l'objet EpisodeElement

    public function obtenirUnEpisodeParId($idEpisode)
    {
        $requeteSql = 'SELECT * FROM episodes_publies WHERE ID ='.$idEpisode.' AND corbeille = "non"';
        $episodes = $this->obtenirObjet($requeteSql, 'EpisodeElement');
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
        $requeteSql = $this->_bdd->prepare('UPDATE episodes_publies SET titre=:titre, date_publication=:date_publication, nombre_vues=:nombre_vues, contenu=:contenu, etat=:etat, auteur=:auteur, image=:image WHERE ID = '.$id);
        $requeteSql->execute(array(
             'titre' => $episode->titre(),
             'date_publication' => $episode->date_publication(),
             'nombre_vues' => $episode->nombre_vues(),
             'contenu' => $episode->contenu(),
             'etat' => $episode->etat(),
             'auteur' => $episode->auteur(),
             'image' => $episode->image()
            ));
    }

    //COMPTEUR DE VUES D'UN EPISODE
    // parametre = (int) ID de l'épisode

    public function compteurVues($id)
    {
        $requeteSql = $this->_bdd->exec('UPDATE episodes_publies SET nombre_vues=nombre_vues+1 WHERE ID = '.$id);
    }
  
}