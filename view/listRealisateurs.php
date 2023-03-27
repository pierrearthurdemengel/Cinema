<?php

ob_start();

$realisateurs = $requetelistRealisateurs->fetchAll();


?>
<p class="uk_label uk-label-warnign">Il y a <?= $requetelistRealisateurs->rowCount() ?> realisateurs</p>
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
        foreach ($realisateurs as $r) {
        ?>
            <tr>
                <td><?= $r["nom"] ?></td>
                <td><?= $r["prenom"] ?></td>
                <td><?= $r["date_naissance"] ?></td>
                <td><?= $r["sexe"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des realisateurs";
$titre_secondaire = "Liste des realisateurs";
$contenu =ob_get_clean();
require "view/template.php";