<?php

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

// Si tout va bien, on peut continuer

// On récupère tout le contenu de la table film_BDD
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
INNER JOIN personne p ON r.personne_id = p.id_personne';

$filmStatement = $db->prepare($sqlQuery);
$filmStatement->execute();
$film = $filmStatement->fetchAll();
?>

<html>
<link rel="stylesheet" type="text/css" href="sheet.css">
<table>
  <thead>
    <tr>
      <th>Titre</th>
      <th>Année</th>
      <th>Réalisateur</th>
      <th>Durée</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach ($film as $film) { ?>
      <tr>
        <td><?php echo $film['titre']; ?></td>
        <td><?php echo $film['annee']; ?></td>
        <td><?php echo $film['nom'] . ' ' . $film['prenom']; ?></td>
        <td><?php echo $film['temps_format']; ?></td>
      </tr>
    <?php } ?>
  </tbody>
</table>
</html>

