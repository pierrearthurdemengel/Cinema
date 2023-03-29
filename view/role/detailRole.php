<?php
ob_start();

$id_acteur = $_GET['id'];
$ActeurParRole = $requeteActeurParRole->fetchAll();
$requeteInfoRole = $requeteInfoRole->fetch();

  
?>
<p>
    Role : <?= $requeteInfoRole['nom_role'] ?><br>
</p>

<table>
    <thead>
        <tr>
            <th>Acteur</th>
            <th>Film</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($ActeurParRole as $ActRole) { ?>
        <tr>
            <td>
            <a href="index.php?action=detailActeur&id=<?= $ActRole["id_acteur"] ?>"><?= $ActRole['acteur'] ?></a>
            </td>
            <td>
            <a href="index.php?action=detailFilm&id=<?= $ActRole["id_film"] ?>"><?= $ActRole['titre'] ?></a>
            </td>
        </tr>
        <?php } ?>
    </tbody>
</table>


<?php
$titre = "Liste des Films ";
$titre_secondaire = "Liste des Films de Role " .$requeteInfoRole['nom_role'];
$contenu = ob_get_clean();
require "view/template.php";
?>
