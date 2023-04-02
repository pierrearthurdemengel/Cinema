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

        $requetelistFilms = $pdo->query("SELECT 
            f.id_film, 
            f.titre, 
            f.annee, 
            TIME_FORMAT(SEC_TO_TIME(f.duree * 60), '%H:%i') as duree_format, 
            f.synopsis, 
            f.note5, 
            f.lien_affiche, 
            f.realisateur_id as realisateur_id,
            CONCAT(p.prenom, ' ', p.nom) AS realisateur,
            g.id_genre as id_genre,
            g.nom_genre as nom_genre
        FROM 
            film f
        LEFT JOIN realisateur r ON f.realisateur_id = r.id_realisateur
        LEFT JOIN appartenir a ON f.id_film = a.id_film
        LEFT JOIN personne p ON p.id_personne = r.personne_id
        LEFT JOIN genre g ON a.id_genre = g.id_genre;
        ");


        $requeteReal = $pdo->query("SELECT 
            CONCAT(p.prenom, ' ', p.nom) AS realisateur,
            id_realisateur 
        from 
            realisateur r
        LEFT JOIN personne p ON p.id_personne = r.personne_id
        GROUP BY id_realisateur
        ");


        $requeteGenre = $pdo->query("SELECT 
            nom_genre,
            id_genre 
        from 
            genre g
        ORDER BY nom_genre;
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
                    sexe,
                    COUNT(c.acteur_id) AS nbFilms
                FROM
                    acteur a
                INNER JOIN personne p ON p.id_personne = a.personne_id
                LEFT JOIN casting c ON a.id_acteur = c.acteur_id
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
            LEFT JOIN film f ON f.id_film = c.film_id
            LEFT JOIN acteur a ON a.id_acteur = c.acteur_id
            LEFT JOIN personne p ON a.personne_id = p.id_personne
            LEFT JOIN role r ON r.id_role = c.role_id
        ");
        $requeteFilm = $pdo->query("SELECT titre, id_film from film ORDER BY titre ASC");

        $requeteActeur = $pdo->query("SELECT nom, prenom, id_acteur from personne p
        LEFT JOIN acteur a ON a.personne_id = p.id_personne
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

            $addgenre = filter_input(INPUT_POST, "nom_genre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($addgenre) {
                $pdo = Connect::seConnecter();
                $requeteaddGenre = $pdo->prepare('INSERT INTO genre VALUES (NULL, :nom_genre)');

                $requeteaddGenre->bindValue(':nom_genre', $addgenre);
                $requeteaddGenre->execute();
                header("Location: index.php?action=listGenres");
                require "view/listGenres.php";
            }
        }
    }


    public function addRole()
    {
        if (isset($_POST["submit"])) {
            $addRole = filter_input(INPUT_POST, "nom_role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($addRole) {
                $pdo = Connect::seConnecter();

                $requeteaddRole = $pdo->prepare('INSERT INTO role VALUES (NULL, :nom_role)');

                $requeteaddRole->bindValue(':nom_role', $addRole);
                $requeteaddRole->execute();

                header("Location: index.php?action=listRoles");
                require "view/listRoles.php";
            }
        }
    }
    public function addActeur()
    {
        if (isset($_POST["submit"])) {

            $addNom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addPrenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addSexe = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addDateNaiss = filter_input(INPUT_POST, "date_naissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($addNom && $addPrenom && $addSexe && $addDateNaiss) {
                $pdo = Connect::seConnecter();

                $requeteaddPersonne = $pdo->prepare('INSERT INTO personne 
                (nom, prenom, sexe, date_naissance) VALUES 
                (:nom, :prenom, :sexe, :date_naissance)');


                $requeteaddPersonne->execute(
                    [
                        "nom" => $addNom,
                        "prenom" => $addPrenom,
                        "sexe" => $addSexe,
                        "date_naissance" => $addDateNaiss
                    ]
                );

                $personne_id = $pdo->lastInsertId();

                $requeteaddActeur = $pdo->prepare("INSERT INTO acteur (personne_id) VALUES (:id_personne)");
                $requeteaddActeur->execute([":id_personne" => $personne_id]);

                header("Location: index.php?action=listActeurs");
            }
        }
    }

    public function addRealisateur()
    {
        if (isset($_POST["submit"])) {
            $addNom = filter_input(INPUT_POST, "nom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addPrenom = filter_input(INPUT_POST, "prenom", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addSexe = filter_input(INPUT_POST, "sexe", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addDateNaiss = filter_input(INPUT_POST, "date_naissance", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if ($addNom && $addPrenom && $addSexe && $addDateNaiss) {
                $pdo = Connect::seConnecter();
                $requeteaddRealisateur = $pdo->prepare('INSERT INTO personne (nom, prenom, sexe, date_naissance) 
                VALUES (:nom, :prenom, :sexe, :date_naissance)');

                $requeteaddRealisateur->execute(
                    [
                        "nom" => $addNom,
                        "prenom" => $addPrenom,
                        "sexe" => $addSexe,
                        "date_naissance" => $addDateNaiss
                    ]
                );

                $personne_id = $pdo->lastInsertId();

                $requeteaddRealisateur = $pdo->prepare("INSERT INTO realisateur(personne_id) VALUES (:id_personne)");
                $requeteaddRealisateur->execute(["id_personne" => $personne_id]);

                header("Location: index.php?action=listRealisateurs");
            }
        }
    }

    public function addCasting()
    {
        if (isset($_POST["submit"])) {

            $addTitre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addActeur = filter_input(INPUT_POST, "acteur", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addRole = filter_input(INPUT_POST, "role", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


            if ($addTitre && $addActeur && $addRole) {

                $pdo = Connect::seConnecter();

                $requeteaddRole = $pdo->prepare('INSERT INTO casting (film_id, acteur_id, role_id) VALUES 
            ( :film_id, :acteur_id, :role_id)');

                $requeteaddRole->execute(
                    [
                        "film_id" => $addTitre,
                        "acteur_id" => $addActeur,
                        "role_id" => $addRole,
                    ]
                );

                header("Location: index.php?action=listCastings");
            }
        }
    }
    public function addFilm()
    {
        if (isset($_POST["submit"])) {

            $addTitre = filter_input(INPUT_POST, "titre", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addAnnee = filter_input(INPUT_POST, "annee", FILTER_SANITIZE_NUMBER_INT);
            $addDuree = filter_input(INPUT_POST, "duree_format", FILTER_SANITIZE_NUMBER_INT);
            $addSynopsis = filter_input(INPUT_POST, "synopsis", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $addNote5 = filter_input(INPUT_POST, "note5", FILTER_SANITIZE_NUMBER_INT);
            $addLien_affiche = filter_input(INPUT_POST, "lien_affiche", FILTER_SANITIZE_URL);
            $realisateur_id = filter_input(INPUT_POST, "realisateur", FILTER_SANITIZE_NUMBER_INT);
            $id_genre = filter_input(INPUT_POST, "id_genre", FILTER_SANITIZE_NUMBER_INT);

            if ($addTitre && $addAnnee && $addDuree && $addSynopsis && $addNote5 && $addLien_affiche && $realisateur_id) {

                $pdo = Connect::seConnecter();
                $requeteaddFilm = $pdo->prepare('INSERT INTO film 
                (titre, annee, duree, synopsis, note5, lien_affiche, realisateur_id)
                VALUES (:titre, :annee, :duree, :synopsis, :note5, :lien_affiche, :realisateur_id)');

                $requeteaddFilm->execute(
                    [
                        "titre" => $addTitre,
                        "annee" => $addAnnee,
                        "duree" => $addDuree,
                        "synopsis" => $addSynopsis,
                        "note5" => $addNote5,
                        "lien_affiche" => $addLien_affiche,
                        'realisateur_id' => $realisateur_id
                    ]
                );

                $film_id = $pdo->lastInsertId(); // Récupérer l'ID du film ajouté

                $requeteaddAppartenir = $pdo->prepare('INSERT INTO appartenir 
                (id_film, id_genre)
                VALUES ( :id_film, :id_genre)');

                $requeteaddAppartenir->execute(
                    [
                        "id_film" => $film_id,
                        "id_genre" => $id_genre
                    ]
                );

                header("Location: index.php?action=listFilms");
            }
        }
    }


};
