<?php
ob_start();
$acteur = $requete->fetch();
echo "<h1>$acteur[nom]</h1>";
?>

<p>
    Filmographie : <a href="index.php?action=detailRealisateur&id=<? $film['id_film'] ?>"><?php echo $film['titre']; ?></a><br>
</p>
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

<?php
$titre = "Détails de l'acteur";
$titre_secondaire = "Titre secondaire";
$contenu =ob_get_clean();
require "view/template.php";
?>
