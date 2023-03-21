<?php

use controller\CinemaController;

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


try {
    // On se connecte à MySQL
    $db = new PDO(
        'mysql:host=localhost;
        dbname=film_pierre-arthur;
        charset=utf8', 
        'root', 
        '',
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
} catch(Exception $e) {
    // En cas d'erreur, on affiche un message et on arrête tout
    die('Erreur : '.$e->getMessage());
}


echo $contenu;