<?php

ob_start();

$realisateurs = $requetelistRealisateurs->fetchAll();


?>
<p class="uk_label uk-label-warnign">Il y a <?= $requetelistRealisateurs->rowCount() ?> realisateurs</p>
<table>
    <thead>
        <tr>
            <th>Réalisateur</th>
            <th>Date de naissance</th>
            <th>Sexe</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($realisateurs as $r) {
            ?>
            <tr>
                <td><a href="index.php?action=detailRealisateur&id=<?= $r["id_personne"] ?>"><?= $r["nom"].' '.$r["prenom"] ?></a></td>
                <td><?= $r["date_naissance"] ?></td>
                <td><?= $r["sexe"] ?></td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
    
    <!-- Formulaire : -->
    <form action="index.php?action=addRealisateur" method="post" ;>
        
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
$titre = "Liste des realisateurs";
$titre_secondaire = "Liste des realisateurs";
$contenu =ob_get_clean();
require "view/template.php";