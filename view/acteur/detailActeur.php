<?php

ob_start();

$acteur = $requete->fetch();

$acteur['p.nom'];

$titre = "Liste des acteurs";
$titre_secondaire = "Liste secondaire des acteurs";
$contenu =ob_get_clean();
require "view/template.php";