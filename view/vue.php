<?php ob_start(); ?>

<p class="uk_label uk-label-warnign">Il y a <? $requete-> rowCount() ?> films</p>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=ed">
    <meta name="viewport" content="width=device-width">
    <link rel="stylesheet" href="https://cdn.jsdelivre">
    <link rel="stylesheet" href="public/css/style.css">
    <titre><?= $titre ?></titre>
</head>
<body>
    <nav class="uk-navbar-container" uk-navbar uk-sti></nav>
    <div id="wrapper" class="uk-container uk-container-expand">
        <main>
            <div id="contenu">
                <h1 class="uk-heading-divider" >PDO Cinema</h1>
                <h2 class="uk-heading-bullet><?= $titre_secondaire ?></h2>
                <?= $contenu ?>
            </div>
        </main>
</body>


<table>
    <thead>
        <tr>
            <th>TITRE</th>
            <th>ANNEE SORTIE</th>
        </tr>
    </thead>
    <tbody>
        <?php 
            foreach($requete-> fetAll() as $film) {
        ?>
        <tr>
            <td><?= $film["titre"] ?></td>
            <td><?= $film["annee"] ?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>

<?php

$titre = "Liste des filmms";
$titre_secondaire = "Liste des films";
$contenu = ob_get_clean();
require "view/template.php";