<?php

ob_start();

$acteurs = $requete->fetchAll();


?>
<p class="uk_label uk-label-warnign">Il y a <?= $requete->rowCount() ?> acteurs</p>
<table>
    <thead>
        <tr>
            <th>Nom</th>
            <th>Prenom</th>
            <th>Date de naissance</th>
            <th>Sexe</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($acteurs as $acteur) {
        ?>
            <tr>
                <td><acteur href="index.php?action=detailActeur&id=<?= $acteur["a.personne_id"] ?>"><?= $acteur["p.nom"].' '.$acteur["p.prenom"] ?></acteur></td>
                <td><?= $acteur["p.nom"] ?></td>
                <td><?= $acteur["p.prenom"] ?></td>
                <td><?= $acteur["p.date_naissance"] ?></td>
                <td><?= $acteur["p.sexe"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des Acteurs";
$titre_secondaire = "Liste des Acteurs";
$contenu =ob_get_clean();
require "view/template.php";