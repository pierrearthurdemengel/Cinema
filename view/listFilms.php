<?php

ob_start();




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
                <td><a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>"><?= $film["titre"] ?></a></td>
                <td><?= $film["annee"] ?></td>
                <td><?= $film["duree_format"] ?></td>
                <td><?= $film["synopsis"] ?></td>
                <td><?= $film["note5"] ?></td>
                <td><img src='<?= $film["lien_affiche"] ?>'></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Formulaire : -->
<form action="view/listFilms.php" method="post">

            <p>
                <label for "titre"> Titre </label>
                <input id="titre" type="text" name="firstTitre">
            </p>
            <p>
                <label for "annee"> annee </label>
                <input id="annee" type="DATE" name="firstAnnee">
            </p>
            <p>
                <label for "duree_format"> durée du film</label>
                <input id="duree_format" type="DATETIME" name="duree_format">
            </p>
            <p>
                <label for "synopsis"> synopsis </label>
                <input id="synopsis" type="text" name="synopsis">
            </p>
            <p>
                <label for "note5"> note /5 </label>
                <input id="note5" type="int" name="note5">
            </p>
            <p>
                <label for "lien_affiche"> affiche </label>
                <input id="lien_affiche" type="text" name="lien_affiche">
            </p>
            <p><input type="submit" value="Enregistrer"></p>
</form> 
<?php

$titre = "Liste des Films";
$titre_secondaire = "Liste secondaire des Films";
$contenu =ob_get_clean();
require "view/template.php";


