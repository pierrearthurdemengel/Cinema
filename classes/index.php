<?php

spl_autoload_register(function ($class_name) {
    require $class_name . '.php';
});


$lucas = new Realisateur("George", "LUCAS", "M", "1950-01-01");
$sf = new Genre("Science-Fiction");

$sw4 = new Film("Star Wars IV", "1977-01-12", 145, "Galaxie...", $sf, $lucas);
$sw5 = new Film("Star Wars V", "1979-01-12", 200, "Galaxie...", $sf, $lucas);
$sw6 = new Film("Star Wars VI", "1982-01-12", 201, "Galaxie...", $sf, $lucas);

$ford = new Acteur("Harison", "FORD", "M", "1960-01-01");
$fisher = new Acteur("Carrie", "FISHER", "F", "1968-01-01");

$hanSolo = new Role("Han Solo");
$leia = new Role("Leia Princess");

$c1 = new Casting($sw4, $ford, $hanSolo);
$c2 = new Casting($sw5, $ford, $hanSolo);
$c3 = new Casting($sw6, $ford, $hanSolo);
$c4 = new Casting($sw4, $fisher, $leia);
$c5 = new Casting($sw5, $fisher, $leia);
$c6 = new Casting($sw6, $fisher, $leia);

echo $sw4->afficherCasting();
echo $hanSolo->afficherCasting();
echo $lucas->afficherFilms();
echo $ford->afficherFilmographie();
echo $sf->afficherFilms();