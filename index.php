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
        case "listRealisateurs" : $ctrlCinema->listRealisateurs(); break;
        case "listGenres" : $ctrlCinema->listGenres(); break;
        case "listPersonnes" : $ctrlCinema->listPersonnes(); break;
        case "listRoles" : $ctrlCinema->listRoles(); break;
        case "listCastings" : $ctrlCinema->listCastings(); break;
        case "detailFilm" : if (isset($_GET["id"])) { $ctrlCinema->detailFilm($id);} break;
        case "detailActeur" : if (isset($_GET["id"])) { $ctrlCinema->detailActeur($id); break;}
        case "detailRealisateur" : if (isset($_GET["id"])) { $ctrlCinema->detailRealisateur($id); break;}
        case "detailGenre" : if (isset($_GET["id"])) { $ctrlCinema->detailGenre($id);} break;
        case "detailRole" : if (isset($_GET["id"])) { $ctrlCinema->detailRole($id); break;}
        case "addGenre" : $ctrlCinema->addGenre(); break;
        case "addRole" : $ctrlCinema->addRole(); break;
        case "addActeur" : $ctrlCinema->addActeur(); break;
        case "addRealisateur" : $ctrlCinema->addRealisateur(); break;
        case "addCasting" : $ctrlCinema->addCasting(); break;
        case "addFilm" : $ctrlCinema->addFilm(); break;
        case "addRealisateurFilm" : $ctrlCinema->addRealisateurFilm(); break;
        // case "addGenreFilm" : : $ctrlCinema->addGenreFilm(); break;
    }
}
else {
  $ctrlCinema-> listFilms();
}

// 
