<?php

ob_start();

echo "<h1>$acteur[nom]</h1>";
?>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Durée</th>
            <th>Synopsis</th>
            <th>note /5</th>
            <th>Affiche</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td><?= $film['titre'] ?></td>
                <td><?= $film['annee'] ?></td>
                <td><?= $film['duree_format'] ?></td>
                <td><?= $film['synopsis'] ?></td>
                <td><?= $film['note5'] ?></td>
                <td><img src='<?= $film["lien_affiche"] ?>'></td></td>
            </tr>
    </tbody>
</table>

<?php
$titre = "Liste des acteurs";
$titre_secondaire = "Liste secondaire des acteurs";
$contenu =ob_get_clean();
require "view/template.php";
?>