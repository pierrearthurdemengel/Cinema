<?php
ob_start();
$filmInfos = $requeteInfo->fetch();
$filmCasting = $requeteCasting->fetchAll();
echo "<h1>" . $filmInfos['titre'] . "</h1>";
echo "<h1>" . $filmCasting[$id]['acteur'] . "</h1>";
?>

<p> 
    Réalisateur : <a href="index.php?action=detailRealisateur&id=<?= $filmInfos["id_realisateur"] ?>"><?php echo $filmInfos["realisateur"]; ?></a><br>
    Durée : <?= $filmInfos["duree_format"] ?><br>
    Année de sortie : <?= $filmInfos["annee"] ?><br>
</p>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Année</th>
            <th>Durée</th>
            <th>Synopsis</th>
            <th>note /5</th>
            <th>Affiche</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $filmInfos['titre'] ?></td>
            <td><?= $filmInfos['annee'] ?></td>
            <td><?= $filmInfos['duree_format'] ?></td>
            <td><?= $filmInfos['synopsis'] ?></td>
            <td><?= $filmInfos['note5'] ?></td>
            <td><img src='<?= $filmInfos["lien_affiche"] ?>'></td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Acteur</th>
            <th>Sexe</th>
            <th>Date de naissance</th>
            <th>Role</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($filmCasting as $cast) { ?>
            <tr>
                <td><a href="index.php?action=detailActeur&id=<?= $cast["id_acteur"] ?>"><?php echo $cast['acteur'] ?></a></td>
                <td><?= $cast['sexe'] ?></td>
                <td><?= $cast['date_naissance'] ?></td>
                <td><?= $cast['nom_role'] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des Films";
$titre_secondaire = "Liste secondaire des Films";
$contenu = ob_get_clean();
require "view/template.php";
?>