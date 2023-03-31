<?php
ob_start();
$castings = $requetelistCastings->fetchAll();
$films =  $requeteFilm->fetchAll();
$acteurs = $requeteActeur->fetchAll();
$roles = $requeteRole->fetchAll();
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

<!-- Formulaire : -->
<form action="index.php?action=addCasting" method="post">

    <p>
        <label for="titre"> Titre </label>
        <select name="titre">
            <?php foreach ($films as $film) {   ?>
                <option value='<?= $film['id_film'] ?>'><?= $film['titre'] ?></option>
            <?php   }   ?>
        </select>
    </p>
    <p>
        <label for="acteur"> Acteur </label>
        <select name="acteur">
            <?php foreach ($acteurs as $acteur) {   ?>
                <option value='<?= $acteur['id_acteur'] ?>'><?= $acteur['nom'] . ' ' . $acteur['prenom'] ?></option>
            <?php   }   ?>
        </select>
    </p>
    <p>
        <label for="role"> Role </label>
        <select name="role">
            <?php foreach ($roles as $role) {   ?>
                <option value='<?= $role['id_role'] ?>'><?= $role['nom_role'] ?></option>
            <?php   }   ?>
        </select>
    </p>
    <p>
        <input type="submit" name="submit" value="Enregistrer">
    </p>
</form>


<?php
$titre = "Liste des Castings";
$titre_secondaire = "Liste des castings";
$contenu = ob_get_clean();
require "view/template.php";
