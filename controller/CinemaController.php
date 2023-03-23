<?php

namespace Controller;
use Model\Connect;

class CinemaController {
    /*lister les films */
    public function listFilms() {
        
        $pdo = Connect::seConnecter();
        $requete = $pdo-> query("
            SELECT id_film, titre, 
            annee, 
            TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as duree_format,
            synopsis,
            note5,
            lien_affiche
            FROM film f
        ");
        $films = $requete->fetchAll();
        require "view/listFilms.php";
    }

    public function listActeurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo-> query("SELECT 
    nom, prenom, date_naissance, sexe
    FROM
    acteur a
    INNER JOIN personne p ON p.id_personne = a.personne_id
    INNER JOIN casting c ON a.id_acteur = c.acteur_id
    INNER JOIN film f ON c.film_id = f.id_film
    GROUP BY a.id_acteur
    ORDER BY nom DESC");
    
        require "view/listActeurs.php";
    }



    public function listRealisateurs() {

        $pdo = Connect::seConnecter();
        $requete = $pdo->query("SELECT 
        nom, prenom, date_naissance, sexe
    FROM
    realisateur r
    INNER JOIN film f ON r.id_realisateur = f.realisateur_id
    INNER JOIN personne p ON r.personne_id = p.id_personne
    GROUP BY r.id_realisateur
    ORDER BY nom DESC    
    ");
        require "view/listRealisateurs.php";
    }

    public function detailFilm($id) {

        $pdo = Connect::seConnecter();

        $requeteInfo = $pdo-> prepare("SELECT 
        id_film, titre, annee, 
        TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as duree_format,
        synopsis,
        note5,
        lien_affiche
        FROM film f
        WHERE id_film = :id");

        $requeteInfo->execute(["id" => $id]);
        $filmInfos = $requeteInfo->fetch();

        
        $requeteCasting = $pdo-> prepare("SELECT
        p.nom, 
        p.prenom,
        p.sexe,
        p.date_naissance,
        r.nom_role
   FROM
       acteur a
       INNER JOIN personne p ON p.id_personne = a.personne_id
       INNER JOIN casting c ON a.id_acteur = c.acteur_id
       INNER JOIN film f ON c.film_id = f.id_film
       INNER JOIN role r ON r.id_role = c.role_id
   WHERE f.id_film = :id");

        $requeteCasting->execute(["id" => $id]);
        $filmCasting = $requeteCasting->fetch();
        require "view/film/detailFilm.php";
    }

    public function detailActeur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo-> prepare("
        SELECT 
        nom, prenom, date_naissance, sexe, nom_role
        FROM
        acteur a
        INNER JOIN personne p ON p.id_personne = a.personne_id
        INNER JOIN casting c ON a.id_acteur = c.acteur_id
        INNER JOIN film f ON c.film_id = f.id_film
        INNER JOIN role r ON c.id_role = r.id_role
        WHERE id_acteur = :id");
    
        $requete->execute(["id" => $id]);
        $acteur = $requete->fetch();
        require "view/acteur/detailActeur.php";
    }

    public function detailRealisateur($id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo-> prepare("SELECT * FROM realisateur WHERE id_realisateur = :id");
        $requete = $requete->execute(["id" => $id]);
        
        require "view/realisateur/detailRealisateur.php";
    }
}
