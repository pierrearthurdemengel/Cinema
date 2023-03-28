<?php
ob_start();
$id_genre = $_GET['id'];
$filmduGenre = $requeteFilmduGenre->fetchAll();
$nomGenre = $filmduGenre[$id_genre]["nom_genre"];
  
?>
<p>
    Genre : <?= $nomGenre ?><br>
</p>
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
$titre = "Liste des Films ";
$titre_secondaire = "Liste des Films de genre " .$nomGenre;
$contenu = ob_get_clean();
require "view/template.php";
?>
