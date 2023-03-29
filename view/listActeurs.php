<?php

ob_start();

$acteurs = $requetelistActeurs->fetchAll();
?>

<p class="uk_label uk-label-warning">Il y a <?= $requetelistActeurs->rowCount() ?> acteurs</p>
<table>
    <thead>
        <tr>
            <th>Acteur</th>
            <th>Date de naissance</th>
            <th>Sexe</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($acteurs as $acteur) {
        ?>
            <tr>
                <td><a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"] ?>"><?= $acteur["acteur"] ?></a></td>
                <td><?= $acteur['date_naissance'] ?></td>
                <td><?= $acteur['sexe'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des Acteurs";
$titre_secondaire = "Liste des Acteurs";
$contenu =ob_get_clean();
require "view/template.php";