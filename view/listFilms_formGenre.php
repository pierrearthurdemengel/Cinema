    <!-- 2 -genre en checkbox pour pouvoir en avoir plusieur (foreach)-->
    <form action="index.php?action=addGenreFilm" method="post" ;>

        <p>
            <label for="nom_genre"> Genre </label>
            <?php foreach ($genres as $genre) {   ?>
                <input id="nom_genre" type="checkbox" name="nom_genre">
                <option value='<?= $genre['id_genre'] ?>'><?= $genre['nom_genre'] ?></option>
        </p>
    <?php   }   ?>

    </form>