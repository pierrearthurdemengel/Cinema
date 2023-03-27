<?php
ob_start();
$acteur = $requeteDetailActeur->fetch();
$filmographie = $requetefilmographie->fetchAll();
echo "<h1>$acteur[acteur]</h1>";
?>

<!-- <p>
    Filmographie : <a href="index.php?action=detailRealisateur&id=<? $film['id_film'] ?>"><?php echo $film['titre']; ?></a><br>
</p> -->
<table>
    <thead>
        <tr>
            <th>Acteur</th>
            <th>Date de naissance</th>
            <th>sexe</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $acteur['acteur'] ?></td>
            <td><?= $acteur['date_naissance'] ?></td>
            <td><?= $acteur['sexe'] ?></td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>Titre</th>
            <th>Role</th>
            <th>Année</th>
        </tr>
    </thead>
    <tbody>
        <?php
            foreach($filmographie as $filmo) { ?>
            <tr>
                <td><?= $filmo['titre'] ?></td>
                <td><?= $filmo['role'] ?></td>
                <td><?= $filmo['annee'] ?></td>
            </tr>
            <?php }
        ?>
    </tbody>
</table>

<?php
$titre = "Filmographie de l'acteur";
$titre_secondaire = "Titre secondaire";
$contenu =ob_get_clean();
require "view/template.php";
?>
