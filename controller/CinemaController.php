<?php

namespace Controller;

use Model\Connect;
// LISTES //
class CinemaController
{
    /*lister les films */
    public function listFilms()
    {

        $pdo = Connect::seConnecter();
        var_dump($pdo);
        $requetelistFilms = $pdo->query("
            SELECT id_film, titre, 
            annee, 
            TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as duree_format,
            synopsis,
            note5,
            lien_affiche
            FROM film f
        ");

        require "view/listFilms.php";
    }



    public function listActeurs()
    {

        $pdo = Connect::seConnecter();
        $requetelistActeurs = $pdo->query("SELECT id_acteur,
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


    public function listRealisateurs()
    {

        $pdo = Connect::seConnecter();
        $requetelistRealisateurs = $pdo->query("
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

    public function listRoles()
    {

        $pdo = Connect::seConnecter();
        $requetelistRoles = $pdo->query("
            SELECT
                r.nom_role AS role,
                f.titre AS titre,
                f.annee AS annee,
                CONCAT(p.prenom, ' ', p.nom) AS acteur,
                CONCAT(UPPER(LEFT(p.sexe, 1)), SUBSTRING(p.sexe, 2)) AS sexe,
                DATE_FORMAT(p.date_naissance, '%d-%m-%Y') AS date_naissance 
            FROM
                film f
            INNER JOIN casting c ON f.id_film = c.film_id
            INNER JOIN acteur a ON a.id_acteur = c.acteur_id
            INNER JOIN personne p ON p.id_personne = a.personne_id
            INNER JOIN role r ON r.id_role = c.role_id
            ORDER BY annee DESC    
        ");
        require "view/listRoles.php";
    }

    public function listGenres()
    {

        $pdo = Connect::seConnecter();
        $requetelistGenres = $pdo->query("
            SELECT id_genre, nom_genre 
            FROM genre
        ");

        require "view/listGenres.php";
    }

    public function listPersonnes()
    {

        $pdo = Connect::seConnecter();
        $requetelistPersonnes = $pdo->query("SELECT 
    nom, prenom, date_naissance, sexe
    FROM
    personnes
    ORDER BY nom DESC");

        require "view/listPersonnes.php";
    }

    public function listCastings()
    {
        $pdo = Connect::seConnecter();
        $requetelistCastings = $pdo->query("
        SELECT
        id_film,
        titre,
        id_personne,
        id_acteur,
        CONCAT(p.prenom, ' ', p.nom) AS acteur,
        id_role,
        nom_role
FROM
   casting c
INNER JOIN film f ON f.id_film = c.film_id
INNER JOIN acteur a ON a.id_acteur = c.acteur_id
INNER JOIN personne p ON a.personne_id = p.id_personne
INNER JOIN role r ON r.id_role = c.role_id
        ");

        require "view/listCastings.php";
    }   
    // FIN DES LISTES //







    // DEBUT DES DETAILS //
    public function detailFilm($id)
    {
        $pdo = Connect::seConnecter();
        $requeteInfo = $pdo->prepare("
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

        $requeteCasting = $pdo->prepare("
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

    public function detailActeur(int $id)
    {
        $pdo = Connect::seConnecter();
        $requeteDetailActeur = $pdo->prepare("
        SELECT 
        a.id_acteur, 
        CONCAT(p.prenom, ' ', p.nom) AS acteur, 
        CONCAT(UPPER(LEFT(p.sexe, 1)), SUBSTRING(p.sexe, 2)) AS sexe,
        DATE_FORMAT(p.date_naissance, '%d-%m-%Y') AS date_naissance 
        FROM acteur a 
        INNER JOIN personne p ON p.id_personne = a.personne_id 
        WHERE a.id_acteur = :id
    ");

        $requeteDetailActeur->execute(["id" => $id]);

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

    public function detailRealisateur(int $id)
    {
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

    public function detailGenre($id)
    {
        $pdo = Connect::seConnecter();
        $requeteFilmduGenre = $pdo->prepare("
        SELECT g.nom_genre AS nom_genre, 
        f.id_film AS id_film, 
        f.titre AS titre
        FROM genre g
        INNER JOIN appartenir a ON a.id_genre = g.id_genre
        INNER JOIN film f ON f.id_film = a.id_film
        WHERE g.id_genre = :id        
                ");
        $requeteFilmduGenre->execute(["id" => $id]);
        require "view/genre/detailGenre.php";
    }
}


                        // FIN DES DETAILS //


                        // METHODE AJOUTER //
                // public function addFilm() {
                //     if (isset($_POST["submit"]))
                //     {
                //         $titre = $_POST["titre"];
                //         $annee = $_POST["annee"];
                //         $duree = $_POST["duree_format"];
                //         $synopsis = $_POST["synopsis"];
                //         $note5 = $_POST["note5"];
                //         $lien_affiche = $_POST["lien_affiche"];
                
                //         $pdo = Connect::seConnecter();
                //         $requeteaddFilm = $pdo->prepare('INSERT INTO contact VALUES (NULL, :titre, :annee, :duree_format, :synopsis, :note5, :lien_affiche)');
                //         $requeteaddFilm->bindValue(':titre', $titre, PDO::PARAM_STR);
                //         $requeteaddFilm->bindValue(':annee', $annee, PDO::PARAM_STR);
                //         $requeteaddFilm->bindValue(':duree_format', $duree, PDO::PARAM_INT);
                //         $requeteaddFilm->bindValue(':synopsis', $synopsis, PDO::PARAM_STR);
                //         $requeteaddFilm->bindValue(':note5', $note5, PDO::PARAM_INT);
                //         $requeteaddFilm->bindValue(':lien_affiche', $lien_affiche, PDO::PARAM_STR);
                //         $requeteaddFilm->execute();
                //         header("Location: index.php?action=listFilms");
                //         // require "view/listFilms.php";
                //     }
                // }