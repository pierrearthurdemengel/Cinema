<?php

ob_start();
$realisateur = $requeteReal->fetch();
$listFilmReal = $requetefilmReal->fetchAll();
echo "<h1>".$realisateur['realisateur']."</h1>";
echo "<h1>".$listFilmReal[0]['titre']."</h1>";

?>

<?php $realisateur['id_realisateur'] ?>"><?php echo $realisateur['realisateur']; ?>

<table>
    <thead>
        <tr>
            <th>Réalisateur</th>
            <th>Date de naissance</th>
            <th>sexe</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $realisateur['realisateur'] ?></td>
            <td><?= $realisateur['date_naissance'] ?></td>
            <td><?= $realisateur['sexe'] ?></td>
        </tr>
    </tbody>
</table>
<table>
    <thead>
        <tr>
            <th>id film</th>
            <th>Titre</th>
            <th>Role</th>
            <th>Année</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td><?= $listFilmReal[0]['id_film'] ?></td>
            <td><?= $listFilmReal[0]['titre'] ?></td>
            <td><?= $listFilmReal[0]['role'] ?></td>
            <td><?= $listFilmReal[0]['annee'] ?></td>
        </tr>
    </tbody>
</table>


<?php
$titre = "Détails réalisateur";
$titre_secondaire = "Liste secondaire des realisateurs";
$contenu =ob_get_clean();
require "view/template.php";
?>