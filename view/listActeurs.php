<?php 

listFilms()
{
    $sqlQuery = 
    'SELECT
f.titre,
f.annee,
TIME_FORMAT(SEC_TO_TIME(f.duree * 60), "%H:%i") as temps_format,
f.synopsis,
f.note5,
f.lien_affiche,
p.nom,
p.prenom,
p.sexe,
p.date_naissance
FROM
film f
INNER JOIN acteur a ON f.acteur_id = a.id_acteur
INNER JOIN personne p ON a.personne_id = p.id_personne
WHERE
a.id_acteur = $_GET["id"]';
}



?>