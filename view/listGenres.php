<?php
ob_start();

$genres = $requetelistGenres->fetchAll();
// echo "<pre>";
// print_r($genres);
// echo "</pre>";
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
$titre_secondaire = "Liste des Genres";
$contenu = ob_get_clean();
require "view/template.php";