<?php

ob_start();

$acteurs = $requetelistActeurs->fetchAll();
?>

<p class="uk_label uk-label-warning">Il y a <?= $requetelistActeurs->rowCount() ?> acteurs</p>
<table>
    <thead>
        <tr>
            <th>Acteur</th>
            <th>Sexe</th>
            <th>Date de naissance</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($acteurs as $acteur) {
        ?>
            <tr>
                <td><a href="index.php?action=detailActeur&id=<?= $acteur["id_acteur"] ?>"><?= $acteur["prenom"]. ' '.$acteur["nom"] ?></a></td>
                <td><?= $acteur['sexe'] ?></td>
                <td><?= $acteur['date_naissance'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<!-- Formulaire : -->
<form action="index.php?action=addActeur" method="post" ;>

    <p>
        <label for="nom"> Nom </label>
        <input id="nom" type="text" name="nom">
    </p>
    <p>
        <label for="prenom"> Prénom </label>
        <input id="prenom" type="text" name="prenom">
    </p>
    <p>
        <label for="sexe"> Sexe </label>
        <input id="sexe" type="text" name="sexe">
    </p>
    <p>
        <label for="date_naissance"> Date de Naissance </label>
        <input id="date_naissance" type="text" name="date_naissance">
    </p>
    <p>
        <input type="submit" name="submit" value="Enregistrer">
    </p>

</form>

<?php
$titre = "ListActeurs";
$titre_secondaire = "Liste des Acteurs";
$contenu = ob_get_clean();
require "view/template.php";
