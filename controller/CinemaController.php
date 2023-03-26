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
    public function addFilm() {
        $pdo = Connect::seConnecter();
        $requeteaddFilm = $pdo->prepare('INSERT INTO contact VALUES (NULL, :titre, :annee, :duree, :synopsis, :note5, :lien_affiche');
        $pdoStat->bindValue(':titre', $_POST['lastName'], PDO::PARAM_STR);
        $pdoStat->bindValue(':annee', $_POST['annee'], PDO::PARAM_STR);
        $pdoStat->bindValue(':duree', $_POST['duree_format'], PDO::PARAM_STR);
        $pdoStat->bindValue(':synopsis', $_POST['synopsis'], PDO::PARAM_STR);
        $pdoStat->bindValue(':note5', $_POST['note5'], PDO::PARAM_STR);
        $pdoStat->bindValue(':lien_affiche', $_POST['lien_affiche'], PDO::PARAM_STR);
        $ajouterFilm = $requeteaddFilm->fetch();
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
        $requete = $pdo->query("
    SELECT 
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
        $requeteInfo = $pdo-> prepare("
        SELECT 
        id_film, titre, annee, 
        TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as duree_format,
        synopsis,
        note5,
        lien_affiche
        FROM film f
        WHERE id_film = :id
        ");
        $requeteInfo->execute(["id" => $id]);

        $requeteCasting = $pdo-> prepare("
        SELECT
        id_acteur,
        CONCAT(p.prenom, ' ', p.nom) AS acteur,
        p.sexe,
        p.date_naissance,
        r.nom_role
   FROM
       acteur a
       INNER JOIN personne p ON p.id_personne = a.personne_id
       INNER JOIN casting c ON a.id_acteur = c.acteur_id
       INNER JOIN film f ON c.film_id = f.id_film
       INNER JOIN role r ON r.id_role = c.role_id
       WHERE f.id_film = :id
   ");

        $requeteCasting->execute(["id" => $id]);
        require "view/film/detailFilm.php";
    }

    public function detailActeur(int $id) {
        $pdo = Connect::seConnecter();
        $requete = $pdo-> prepare("
        SELECT 
        a.id_acteur, 
        CONCAT(p.prenom, ' ', p.nom) AS acteur, 
        CONCAT(UPPER(LEFT(p.sexe, 1)), SUBSTRING(p.sexe, 2)) AS sexe,
        DATE_FORMAT(p.date_naissance, '%d-%m-%Y') AS date_naissance 
        FROM acteur a 
        INNER JOIN personne p ON p.id_personne = a.personne_id 
        WHERE a.id_acteur = :id
    ");
    
        $requete->execute(["id" => $id]);

        $requetefilmographie = $pdo->prepare("
        SELECT 
		  	f.id_film AS id_film, 
         	f.titre AS titre, 
		   	r.nom_role AS role, 
		  	f.annee AS annee
         FROM 
			casting c
         INNER JOIN film f ON f.id_film = c.film_id
         INNER JOIN role r ON r.id_role = c.role_id
         WHERE 
			acteur_id = :id
         ORDER BY annee DESC
        ");

        $requetefilmographie->execute(["id" => $id]);

        require "view/acteur/detailActeur.php";
    }
    
    public function detailRealisateur(int $id) {
        $pdo = Connect::seConnecter();
        $requeteReal = $pdo->prepare("
        SELECT 
        r.id_realisateur, 
        CONCAT(p.prenom, ' ', p.nom) AS realisateur, 
        CONCAT(UPPER(LEFT(p.sexe, 1)), SUBSTRING(p.sexe, 2)) AS sexe,
        DATE_FORMAT(p.date_naissance, '%d-%m-%Y') AS date_naissance 
        FROM realisateur r 
        INNER JOIN personne p ON p.id_personne = r.personne_id
        WHERE r.id_realisateur = :id
    ");
    // 1ere SQL ok
        
        $requeteReal->execute(["id" => $id]);

        $requetefilmReal = $pdo->prepare("
        SELECT 
		  	f.id_film AS id_film, 
         	f.titre AS titre, 
		   	r.nom_role AS role, 
		  	f.annee AS annee
         FROM 
			casting c
         INNER JOIN film f ON f.id_film = c.film_id
         INNER JOIN role r ON r.id_role = c.role_id
         WHERE 
			realisateur_id = :id
         ORDER BY annee DESC
        ");
        // 2eme SQL ok

        $requetefilmReal->execute(["id" => $id]);

        require "view/realisateur/detailRealisateur.php";
    }
}
