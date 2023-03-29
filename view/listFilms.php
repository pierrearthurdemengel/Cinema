<?php

ob_start();

$films = $requetelistFilms->fetchAll();
$realisateurs = $requeteRealisateur->fetchAll();
$genres = $requeteGenre->fetchAll();


?>

<!-- <p class="uk_label uk-label-warnign">Il y a <?= $requetelistFilms->rowCount() ?> films</p> -->
<table>
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
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
                <td><?= $film["annee"] ?></td>
                <td><?= $film["duree_format"] ?></td>
                <td><?= $film["synopsis"] ?></td>
                <td><?= $film["note5"] ?></td>
                <td><img src='<?= $film["lien_affiche"] ?>'></td>
                <td><a href="index.php?action=detailRealisateur&id=<?= $realisateurs["id_personne"] ?>"><?= $realisateurs["realisateur"] ?></a></td>
                <td><a href="index.php?action=detailGenre&id=<?= $genres["id_genre"] ?>"><?= $genres["nom_genre"] ?></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Formulaire : -->
<form action="view/listFilms.php" method="post">

    <p>
        <label for="titre"> Titre </label>
        <input id="titre" type="text" name="Titre">
    </p>
    <p>
        <label for="annee"> annee </label>
        <input id="annee" type="texte" name="Annee">
    </p>
    <p>
        <label for="duree_format"> durée du film</label>
        <input id="duree_format" type="number" name="duree">
    </p>
    <p>
        <label for="synopsis"> synopsis </label>
        <input id="synopsis" type="text" name="synopsis">
    </p>
    <p>
        <label for="note5"> note /5 </label>
        <input id="note5" type="number" name="note5">
    </p>
    <p>
        <label for="lien_affiche"> affiche </label>
        <input id="lien_affiche" type="url" name="lien_affiche">
    </p>
    <!-- 1 - realisateur dans un eliste éroulante  -->
    <form action="index.php?action=addRealisateur" method="post" ;>

        <p>
            <label for="realisateur"> Réalisateur </label>
            <select name="realisateur">
                <?php foreach ($realisateurs as $realisateur) {   ?>
                    <option value='<?= $realisateur['id_realisateur'] ?>'><?= $realisateur['realisateur'] ?></option>
                <?php   }   ?>
            </select>
        </p>
    </form>
    <!-- 2 -genre en checkbox pour pouvoir en avoir plusieur (foreach)-->
    <form action="index.php?action=addGenre" method="post" ;>

        <p>
            <label for="nom_genre"> Nouveau Genre </label>
            <input id="nom_genre" type="text" name="nom_genre">
            <?php foreach ($genres as $genre) {   ?>
        </p>
        <p><input type="checkbox" name="submit" value="Enregistrer"></p>
    <?php   }   ?>

    </form>


    <p><input type="submit" value="Enregistrer"></p>
</form>
<?php

$titre = "Liste des Films";
$titre_secondaire = "Liste secondaire des Films";
$contenu = ob_get_clean();
require "view/template.php";
