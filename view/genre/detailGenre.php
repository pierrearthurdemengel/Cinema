<?php
ob_start();

$filmduGenre = $requeteFilmduGenre->fetchAll();
echo $filmduGenre[$id]['nom_genre'];

?>

Film : <a href="index.php?action=detailFilm&id=<?= $filmduGenre[$id]["id_film"] ?>"><?php $filmduGenre[$id]["titre"] ?></a><br>

<table>
    <tbody>
    <?php    foreach ($filmduGenre as $film) { ?>
        <tr>
        <li><a href="index.php?action=detailFilm&id=<?= $film["id_film"] ?>"><?php echo $film["titre"]; ?></a></li>
        </tr>
        <?php } ?>
    </tbody>
</table>


<?php
$titre = "Liste des Films";
$titre_secondaire = "Liste des Films de genre " . $filmduGenre[$id]['nom_genre'];
$contenu = ob_get_clean();
require "view/template.php";
?>
