<?php

ob_start();

$films = $requetelistFilms->fetchAll();
$realisateurs = $requeteReal->fetchAll();
$genres = $requeteGenre->fetchAll();


?>

<!-- <p class="uk_label uk-label-warnign">Il y a <?= $requetelistFilms->rowCount() ?> films</p> -->
<table>
    <thead>
        <tr>
            <th>TITRE</th>
            <th>Année</th>
            <th>Durée</th>
            <th>Synopsis</th>
            <th>Note / 5</th>
            <th>Affiche</th>
            <th>Realisateur</th>
            <th>Genre</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($films as $film) {
        ?>
            <tr>
                <td><a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>"><?= $film["titre"] ?></a></td>
                <td>
                    <?= $film["annee"] ?>
                </td>
                <td>
                    <?= $film["duree_format"] ?>
                </td>
                <td>
                    <?= $film["synopsis"] ?>
                </td>
                <td>
                    <?= $film["note5"] ?>
                </td>
                <td><img src='<?= $film["lien_affiche"] ?>'></td>
                <td><a href="index.php?action=detailRealisateur&id=<?= $film["realisateur_id"] ?>"><?= $film["realisateur"] ?></a></td>
                <td><a href="index.php?action=detailGenre&id=<?= $film["id_genre"] ?>"><?= $film["nom_genre"] ?></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Formulaire : -->
<form action="index.php?action=addFilm" method="post">


    <label for="titre"> Titre </label>
    <input id="titre" type="text" name="titre"></br>

    <label for="annee"> annee </label>
    <input id="annee" type="number" name="annee"></br>

    <label for="duree_format"> durée du film</label>
    <input id="duree_format" type="number" name="duree_format"></br>

    <label for="synopsis"> synopsis </label>
    <input id="synopsis" type="text" name="synopsis"></br>

    <label for="note5"> note /5 </label>
    <input id="note5" type="number" name="note5"></br>

    <label for="lien_affiche"> affiche </label>
    <input id="lien_affiche" type="url" name="lien_affiche"></br>


    <!-- 1 - realisateur dans un eliste éroulante  -->

    <label for="realisateur"> Réalisateur </label>
    <select name="realisateur">
        <?php foreach ($realisateurs as $realisateur) { ?>
            <option value='<?= $realisateur['id_realisateur'] ?>'><?= $realisateur['realisateur'] ?></option>
        <?php } ?>
    </select>

    <!-- 2 - Genre en checkbox-->

        <?php foreach ($genres as $genre) { ?>
            <label>
                <input type="checkbox" name="genre" value="<?= $genre['id_genre'] ?>">
                <?= $genre['nom_genre'] ?>
            </label>
        <?php } ?>
    </select>


    <input type="submit" value="Enregistrer" name="submit">




</form></br>
<?php

$titre = "Liste des Films";
$titre_secondaire = "Liste secondaire des Films";
$contenu = ob_get_clean();
require "view/template.php";
