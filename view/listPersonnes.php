<?php

ob_start();

$personnes = $requetelistpersonnes->fetchAll();
echo $personnes;
?>

<p class="uk_label uk-label-warning">Il y a <?= $requetelistpersonnes->rowCount() ?> personnes</p>
<table>
    <thead>
        <tr>
            <th>Personne</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($personnes as $personne) {
        ?>
            <tr>
                <td><a href="index.php?action=detailPersonne&id=<?= $personne["id_personne"] ?>"><?= $personne["nom_personne"] ?></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des personnes";
$titre_secondaire = "Liste bis des personnes";
$contenu = ob_get_clean();
require "view/template.php";