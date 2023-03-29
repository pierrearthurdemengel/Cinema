<?php 
?>


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
        <nav>
            <ul>
                <li><a href="index.php?action=listFilms">Liste des films</a></li>
                <li><a href="index.php?action=listActeurs">Liste des acteurs</a></li>
                <li><a href="index.php?action=listRealisateurs">Liste des réalisateurs</a></li>
                <li><a href="index.php?action=listCastings">Liste des Castings</a></li>
                <li><a href="index.php?action=listGenres">Liste des Genres</a></li>
                <li><a href="index.php?action=listRoles">Liste des Roles</a></li>
                <li><a href="index.php?action=listPersonnes">Liste des Personnes</a></li>    
            </ul>
        </nav>
        <main>
            <div id="contenu">
                <h1 class="uk-heading-divider" >PDO Cinema</h1>
                <h2 class="uk-heading-bullet"><?= $titre_secondaire ?></h2>
                <?= $contenu ?>
            </div>
        </main>
</body>




<?php
