<?php
ob_start();

$castings = $requetelistCastings->fetchAll();
?>

<p class="uk_label uk-label-warning">Il y a <?= $requetelistCastings->rowCount() ?> genres</p>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Acteur</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($castings as $casting) {
        ?>
            <tr>
                <td><a href="index.php?action=detailFilm&id=<?= $casting["id_film"] ?>"><?= $casting["titre"] ?></a></td>
                <td><a href="index.php?action=detailActeur&id=<?= $casting["id_acteur"] ?>"><?= $casting["acteur"] ?></td>
                <td><a href="index.php?action=detailRole&id=<?= $casting["id_role"] ?>"><?= $casting["nom_role"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des Genres";
$titre_secondaire = "Liste bis des Genres";
$contenu = ob_get_clean();
require "view/template.php";