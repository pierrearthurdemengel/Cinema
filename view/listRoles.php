<?php
ob_start();

$roles = $requetelistRoles->fetchAll();
// 

?>

<p class="uk_label uk-label-warning">Il y a <?= $requetelistRoles->rowCount() ?> Roles</p>
<table>
    <thead>
        <tr>
            <th>Role</th>
            <th>Titre</th>
            <th>Annee</th>
            <th>Acteur</th>
            <th>Sexe</th>
            <th>Date de naissance</th>
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($roles as $role) {
        ?>
            <tr>
                <td><a href="index.php?action=detailRole&id=<?=$role["id_role"] ?>">  <?= $role["role"]; ?></a></td>
                <td><?= $role["titre"] ?></td>
                <td><?= $role["annee"] ?></td>
                <td><a href="index.php?action=detailRole&id=<?=$role["personne_id"] ?>"> <?= $role["acteur"]; ?></a></td>
                <td><?= $role["sexe"] ?></td>
                <td><?= $role["date_naissance"] ?></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

<?php
$titre = "Liste des Acteurs par role";
$titre_secondaire = "Liste des Acteurs";
$contenu =ob_get_clean();
require "view/template.php";
