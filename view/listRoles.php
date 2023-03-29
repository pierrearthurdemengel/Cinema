<?php
ob_start();

$roles = $requetelistRoles->fetchAll();
 

?>

<p class="uk_label uk-label-warning">Il y a <?= $requetelistRoles->rowCount() ?> Roles</p>
<table>
    <thead>
        <tr>
            <th>Role</th>
       
        </tr>
    </thead>
    <tbody>
        <?php
        foreach ($roles as $role) {
        ?>
            <tr>
                <td><a href="index.php?action=detailRole&id=<?=$role["id_role"] ?>">  <?= $role["role"]; ?></a></td>
            </tr>
        <?php } ?>
    </tbody>
</table>

                            <!-- Formulaire : -->
<form action="index.php?action=addRole" method="post";>

<p>
    <label for="nom_role"> Nouveau Role </label>
    <input id="nom_role" type="text" name="nom_role">
</p>

<p><input type="submit" name ="submit" value="Enregistrer"></p>

</form>

<?php
$titre = "ListRole";
$titre_secondaire = "Liste des Acteurs";
$contenu =ob_get_clean();
require "view/template.php";
