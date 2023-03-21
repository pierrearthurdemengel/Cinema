<?php

use Controller\CinemaController;

spl_autoload_register(function ($class_name) {
    include $class_name . '.php';
});

$ctrlCinema = new CinemaController();

$id=(isset($_GET["id"])) ? $_GET["id"] : null;
// $type = (isset($_GET["type"])) ? $_GET["type"] : null;

if(isset($_GET["action"])) {
    switch ($_GET["action"]) {
            //Films
        case "listFilms" : $ctrlCinema-> listFilms(); break;
        case "listActeurs" : $ctrlCinema->listActeurs(); break;
    }
}
else {
  $ctrlCinema-> listFilms();
}



// Si tout va bien, on peut continuer

// // On récupère tout le contenu de la table film_BDD
// $sqlQuery = 'SELECT
// f.titre,
// f.annee,
// TIME_FORMAT(SEC_TO_TIME(f.duree * 60), "%H:%i") as temps_format,
// f.synopsis,
// f.note5,
// f.lien_affiche,
// p.nom,
// p.prenom,
// p.sexe,
// p.date_naissance
// FROM
// film f
// INNER JOIN realisateur r ON f.realisateur_id = r.id_realisateur
// INNER JOIN personne p ON r.personne_id = p.id_personne
// ORDER BY f.annee DESC';

// $filmStatement = $db->prepare($sqlQuery);
// $filmStatement->execute();
// $film = $filmStatement->fetchAll();
// ?>

