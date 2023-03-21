<?php

listFilms() {
$sqlQuery = 'SELECT
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
INNER JOIN realisateur r ON f.realisateur_id = r.id_realisateur
INNER JOIN personne p ON r.personne_id = p.id_personne
ORDER BY f.annee DESC';
}
?>