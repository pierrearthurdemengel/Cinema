<?php
ob_start();

$genres = $requetelistGenres->fetchAll();
echo $genres;
?>

<p class="uk_label uk-label-warning">Il y a <?= $requetelistGenres->rowCount() ?> genres</p>
<table>
    <thead>
        <tr>
            <th>Genre</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($genres as $genre) {
        ?>
            <tr>
                <td><a href="index.php?action=detailGenre&id=<?= $genre["id_genre"] ?>"><?= $genre["nom_genre"] ?></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des Genres";
$titre_secondaire = "Liste bis des Genres";
$contenu = ob_get_clean();
require "view/template.php";