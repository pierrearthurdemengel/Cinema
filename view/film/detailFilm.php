<?php

ob_start();

echo "<h1>$filmInfos[titre]</h1>";
echo "<h1>$filmCasting[nom]</h1>";
?>

<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Année</th>
            <th>Durée</th>
            <th>Synopsis</th>
            <th>note /5</th>
            <th>Affiche</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td><?= $filmInfos['titre'] ?></td>
                <td><?= $filmInfos['annee'] ?></td>
                <td><?= $filmInfos['duree_format'] ?></td>
                <td><?= $filmInfos['synopsis'] ?></td>
                <td><?= $filmInfos['note5'] ?></td>
                <td><img src='<?= $filmInfos["lien_affiche"] ?>'></td></td>
            </tr>
    </tbody>
</table>

<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prénom</th>
            <th>Sexe</th>
            <th>Date de naissance</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
            <tr>
                <td><?= $filmCasting['nom'] ?></td>
                <td><?= $filmCasting['prenom'] ?></td>
                <td><?= $filmCasting['sexe'] ?></td>
                <td><?= $filmCasting['date_naissance'] ?></td>
                <td><?= $filmCasting['role'] ?></td>
            </tr>
    </tbody>
</table>

<?php
$titre = "Liste des Films";
$titre_secondaire = "Liste secondaire des Films";
$contenu = ob_get_clean();
require "view/template.php";
?>