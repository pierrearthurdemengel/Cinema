<?php
ob_start();
$genres = $requetelistGenres->fetchAll();
// $addgenre = $requeteaddGenre->fetch();
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

                            <!-- Formulaire : -->
<form action="index.php?action=addGenre" method="post";>

            <p>
                <label for="nom_genre"> Nouveau Genre </label>
                <input id="nom_genre" type="text" name="nom_genre">
            </p>
            <p><input type="submit" name ="submit" value="Enregistrer"></p>

</form> 
<?php
$titre = "listGenres";
$titre_secondaire = "Liste des Genres";
$contenu = ob_get_clean();
require "view/template.php";
?>