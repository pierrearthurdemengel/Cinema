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
        SELECT 
            f.id_film, 
            f.titre, 
            f.annee, 
            TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as duree_format, 
            f.synopsis, 
            f.note5, 
            f.lien_affiche, 
            f.realisateur_id AS id_realisateur,
            CONCAT(p.prenom, ' ', p.nom) AS realisateur,
            g.id_genre,
            g.nom_genre
        FROM film f
        JOIN realisateur r ON f.realisateur_id = r.id_realisateur
        JOIN appartenir a ON f.id_film = a.id_film
        JOIN personne p ON p.id_personne = r.personne_id
        JOIN genre g ON a.id_genre = g.id_genre;
        ");

        require "view/listFilms.php";
    }



    public function listActeurs()
    {

        $pdo = Connect::seConnecter();
        $requetelistActeurs = $pdo->query("SELECT id_acteur,
                p.nom,
                p.prenom,
                date_naissance, 
                sexe
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
        p.nom,
        p.prenom,
        date_naissance, 
        sexe,
        id_personne
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
                id_role,
                nom_role AS role
            FROM
               role 
            ORDER BY nom_role DESC    
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
        $requeteFilm = $pdo->query("SELECT titre, id_film from film ORDER BY titre ASC");
        
        $requeteActeur = $pdo->query("SELECT nom, prenom, id_acteur from personne p
        INNER JOIN acteur a ON a.personne_id = p.id_personne
         ORDER BY nom ASC");
        
        $requeteRole = $pdo->query("SELECT nom_role, id_role from role ORDER BY nom_role ASC");
        require "view/listCastings.php";
    }

    public function listPersonnes()
    {

        $pdo = Connect::seConnecter();
        $requetelistPersonnes = $pdo->query("SELECT 
    CONCAT(p.prenom, ' ', p.nom) AS personne, 
    sexe, date_naissance
    FROM
    personne
    ORDER BY nom DESC");

        require "view/listPersonnes.php";
    }
    // FIN DES LISTES //







    // DEBUT DES DETAILS //
    public function detailFilm($id)
    {
        $pdo = Connect::seConnecter();
        $requeteInfo = $pdo->prepare("
        SELECT 
            f.id_film, 
            f.titre, 
            f.annee, 
            TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') AS duree_format,
            f.synopsis, f.note5, f.lien_affiche,
            p.id_personne AS id_realisateur, p.nom AS realisateur
        FROM film f
        INNER JOIN personne p ON f.realisateur_id = p.id_personne
        WHERE f.id_film = :id
        ");
        $requeteInfo->execute(["id" => $id]);

        $requeteCasting = $pdo->prepare("
        SELECT
        a.id_acteur AS id_acteur,
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
        SELECT titre, annee
        FROM film
        WHERE realisateur_id = :id
        ORDER BY annee DESC
        ");
        // 2eme SQL ok

        $requetefilmReal->execute(["id" => $id]);

        require "view/realisateur/detailRealisateur.php";
    }

    public function detailGenre(int $id)
    {
        $pdo = Connect::seConnecter();
        $requeteFilmduGenre = $pdo->prepare("
        SELECT 
            g.nom_genre AS nom_genre,
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

    public function detailRole(int $id)
    {
        $pdo = Connect::seConnecter();
        $requeteActeurParRole = $pdo->prepare("
        SELECT 
                a.id_acteur AS id_acteur, 
                CONCAT(p.prenom, ' ', p.nom) AS acteur, 
                f.id_film AS id_film,
                f.titre, 
                r.nom_role AS role
        FROM acteur a
        JOIN personne p ON a.personne_id = p.id_personne
        JOIN casting c ON a.id_acteur = c.acteur_id
        JOIN film f ON c.film_id = f.id_film
        JOIN role r ON c.role_id = r.id_role
        WHERE r.id_role = :id ;
            ");

        $requeteInfoRole = $pdo->prepare("SELECT * from role WHERE id_role = :id");
        $requeteActeurParRole->execute(["id" => $id]);
        $requeteInfoRole->execute(["id" => $id]);
        require "view/role/detailRole.php";
    }

    // FIN DES DETAILS //


    // METHODE AJOUTER //


    public function addGenre()
    {
        if (isset($_POST["submit"])) {
            $addgenre = $_POST["nom_genre"];
            $pdo = Connect::seConnecter();
            $requeteaddGenre = $pdo->prepare('INSERT INTO genre VALUES (NULL, :nom_genre)');

            $requeteaddGenre->bindValue(':nom_genre', $addgenre);
            $requeteaddGenre->execute();
            header("Location: index.php?action=listGenres");
            require "view/listGenres.php";
        }
    }


    public function addRole()
    {
        if (isset($_POST["submit"])) {
            $addRole = $_POST["nom_role"];
            $pdo = Connect::seConnecter();
            $requeteaddRole = $pdo->prepare('INSERT INTO role VALUES (NULL, :nom_role)');

            $requeteaddRole->bindValue(':nom_role', $addRole);
            $requeteaddRole->execute();

            header("Location: index.php?action=listRoles");
            require "view/listRoles.php";
        }
    }

    public function addActeur()
    {
        if (isset($_POST["submit"])) {
            $addNom = $_POST["nom"];
            $addPrenom = $_POST["prenom"];
            $addSexe = $_POST["sexe"];
            $addDateNaiss = $_POST["date_naissance"];

            $pdo = Connect::seConnecter();
            $requeteaddRole = $pdo->prepare('INSERT INTO personne VALUES 
            (NULL, :nom, :prenom, :sexe, :date_naissance)');
            $requeteaddRole->bindValue(':nom', $addNom);
            $requeteaddRole->bindValue(':prenom', $addPrenom);
            $requeteaddRole->bindValue(':sexe', $addSexe);
            $requeteaddRole->bindValue(':date_naissance', $addDateNaiss);
            $requeteaddRole->execute();
            

            header("Location: index.php?action=listActeurs");
            require "view/listActeurs.php";
        }
    }

    public function addRealisateur()
    {
        if (isset($_POST["submit"])) {
            $addNom = $_POST["nom"];
            $addPrenom = $_POST["prenom"];
            $addSexe = $_POST["sexe"];
            $addDateNaiss = $_POST["date_naissance"];

            $pdo = Connect::seConnecter();
            $requeteaddRole = $pdo->prepare('INSERT INTO personne VALUES 
            (NULL, :nom, :prenom, :sexe, :date_naissance)');
            $requeteaddRole->bindValue(':nom', $addNom);
            $requeteaddRole->bindValue(':prenom', $addPrenom);
            $requeteaddRole->bindValue(':sexe', $addSexe);
            $requeteaddRole->bindValue(':date_naissance', $addDateNaiss);
            $requeteaddRole->execute();
            // requeteaddRole

            header("Location: index.php?action=listRealisateurs");
            require "view/listRealisateurs.php";
        }
    }

    public function addCasting()
    {
            if (isset($_POST["submit"])) 
        {
            $addTitre = $_POST["titre"];
            $addActeur = $_POST["acteur"];
            $addRole = $_POST["role"];

            
            $pdo = Connect::seConnecter();
            $requeteaddRole = $pdo->prepare('INSERT INTO casting VALUES 
            ( :id_film, :id_acteur, :id_role)');
            $requeteaddRole->bindValue(':id_film', $addTitre);
            $requeteaddRole->bindValue(':id_acteur', $addActeur);
            $requeteaddRole->bindValue(':id_role', $addRole);
            $requeteaddRole->execute();
            

            header("Location: index.php?action=listCastings");
            require "view/listCastings.php";
        }
    }
    public function addFilm() {
            if (isset($_POST["submit"]))
        {
                $titre = $_POST["titre"];
                $annee = $_POST["annee"];
                $duree = $_POST["duree_format"];
                $synopsis = $_POST["synopsis"];
                $note5 = $_POST["note5"];
                $lien_affiche = $_POST["lien_affiche"];
                $realisateurs = $_POST["realisateur"];
                $genres = $_POST["genre"];
        
                $pdo = Connect::seConnecter();
                $requeteaddFilm = $pdo->prepare('INSERT INTO film VALUES (NULL, :titre, :annee, :duree_format, :synopsis, :note5, :lien_affiche, NULL, :genre)');
                $requeteRealisateur = $pdo->prepare('INSERT INTO film VALUES (NULL, :realisateur)');
                $$requeteGenre = $pdo->prepare('INSERT INTO film VALUES (NULL, :genres)');



                $requeteaddFilm->bindValue(':titre', $titre);
                $requeteaddFilm->bindValue(':annee', $annee);
                $requeteaddFilm->bindValue(':duree_format', $duree);
                $requeteaddFilm->bindValue(':synopsis', $synopsis);
                $requeteaddFilm->bindValue(':note5', $note5);
                $requeteaddFilm->bindValue(':lien_affiche', $lien_affiche);
                $requeteRealisateur->bindValue(':realisateur', $realisateurs);
                $$requeteGenre->bindValue(':genre', $genres);
                $requeteaddFilm->execute();
                
                header("Location: index.php?action=listFilms");
                require "view/listFilms.php";
        }

    }


};
