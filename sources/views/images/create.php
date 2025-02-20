<?php
$title = 'Créer une image';
include __DIR__ . "/../layout/header.php";
?>
<div class="Container">
    <h1><em>Créer une image</em></h1>

    <form class="input_container" action="/images/<?= $groupId ?>" method="post" enctype="multipart/form-data">
        <input class="input input--no-show" type="text" id="group_id" name="group_id" value="<?= $groupId ?>" required
            readonly><br>


        <div class="dropzone__container">
            <div class="dropzone" id="dropzone">
                <span class="dropzone__icon">📷</span>
                <span class="dropzone__text">Glissez-déposez une image ou cliquez pour sélectionner un fichier</span>
            </div>

            <input type="file" id="image_file" name="image_file" required hidden>
            <p class="dropzone__preview" id="file-name"></p>

            <input class="button button--primary button--md" type="submit" value="Create Image">
        </div>
    </form>



</div>