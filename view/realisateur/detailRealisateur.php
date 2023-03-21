<?php

ob_start();

$realisateur = $requete->fetch();


?>


<?=$realisateur['nom'].' '.$realisateur['prenom'];?>





<?php

$titre = "Liste des realisateurs";
$titre_secondaire = "Liste secondaire des realisater urs";
$contenu =ob_get_clean();
require "view/template.php";