<?php

ob_start();

$films = $requete->fetchAll();


?>
<p class="uk_label uk-label-warnign">Il y a <?= $requete->rowCount() ?> films</p>
<table>
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
            <th>Durée</th>
            <th>Synopsis</th>
            <th>Note / 5</th>
            <th>affiche</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($films as $film) {
        ?>
            <tr>
                <td><?= $film["titre"] ?></td>
                <td><?= $film["annee"] ?></td>
                <td><?= $film["duree_format"] ?></td>
                <td><?= $film["synopsis"] ?></td>
                <td><?= $film["note5"] ?></td>
                <td><?= $film["lien_affiche"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des Films";
$titre_secondaire = "Liste secondaire des Films";
$contenu =ob_get_clean();
require "view/template.php";


