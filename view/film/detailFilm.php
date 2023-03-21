<?php

ob_start();

$film = $requete->fetch();

$film['titre'];


$titre = "Liste des Films";
$titre_secondaire = "Liste secondaire des Films";
$contenu =ob_get_clean();
require "view/template.php";