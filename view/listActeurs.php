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
        foreach ($acteurs as $a) {
        ?>
            <tr>
                <td><?= $a["nom"] ?></td>
                <td><?= $a["prenom"] ?></td>
                <td><?= $a["date_naissance"] ?></td>
                <td><?= $a["sexe"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des Acteurs";
$titre_secondaire = "Liste des Acteurs";
$contenu =ob_get_clean();
require "view/template.php";