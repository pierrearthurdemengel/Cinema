<?php
var_dump($_POST);

//ouverture d'une connection à la bdd cinema
new PDO('mysql:host=localhost';'dbname=cinema','root', '');

//préparation de la requète d'insertion (SQL)
$pdoStat = $objetPdo->prepare('INSERT INTO contact VALUES (NULL, :titre, :annee, :duree, :synopsis, :note5, :lien_affiche');

//liaison de chaque marqueur à une valeur
$pdoStat->bindValue(':titre', $_POST['lastName'], PDO::PARAM_STR);
$pdoStat->bindValue(':annee', $_POST['annee'], PDO::PARAM_STR);
$pdoStat->bindValue(':duree', $_POST['duree_format'], PDO::PARAM_STR);
$pdoStat->bindValue(':synopsis', $_POST['synopsis'], PDO::PARAM_STR);
$pdoStat->bindValue(':note5', $_POST['note5'], PDO::PARAM_STR);
$pdoStat->bindValue(':lien_affiche', $_POST['lien_affiche'], PDO::PARAM_STR);


//exectution de la requête préparée
$insertIsOk = $pdoStat->execute();

if($insertIsOk) {
    $message = 'le film a bien été ajouté';
}
else {
    $message = 'Erreur';
};
?>

<!doctype html>
<html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport">
            content="width=device-width, user-scalable=no, inititial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <body>
            <h1>Insertion Film</h1>
            <p><?php echo $message; ?></p>
        </body>
    </head>
</html>