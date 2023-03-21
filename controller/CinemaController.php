<?php

namespace Controller;
use Model\Connect;

class CinemaController {
    /*lister les films */
    public function listFilms() {

        $pdo = Connect::seConnecter();
        $requete = $pdo-> query("
            SELECT titre, 
            annee, 
            TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as duree_format,
            synopsis,
            note5,
            lien_affiche
            FROM film f
        ");
        require "view/listFilms.php";
    }

    public function listActeurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo-> query("
            SELECT nom, prenom, date_naissance, sexe
            FROM personne
        ");
        require "view/listActeurs.php";
    }

    public function listRealisateurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo-> query("
            SELECT nom, prenom, date_naissance, sexe
            FROM personne
        ");
        require "view/listRealisateurs.php";
    }

    public function detActeur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo-> prepare("SELECT * FROM acteur WHERE id_acteur = id");
        $requete->execute(["id" => $id]);
        require "view/acteur/detailActeur.php";
    }

    public function detRealisateur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo-> prepare("SELECT * FROM realisateur WHERE id_realisateur = id");
        $requete = $requete->execute(["id" => $id]);
        require "view/realisateur/detailRealisateur.php";
    }
}
