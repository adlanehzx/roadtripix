<?php
$title = 'Créer une image';
include __DIR__ . "/../layout/header.php";
?>
<div class= "Container">
        <h1><em>Créer une image</em></h1>

<form class= "input_container" action="/images/<?= $groupId ?>" method="post" enctype="multipart/form-data">
    <label for="group_id">Group ID:</label>
    <input class="input" type="text" id="group_id" name="group_id" value="<?= $groupId ?>" required readonly><br>

    <label for="image_file" class="dropzone" id="dropzone">
      <span class="dropzone__icon">📂</span>
      <span class="dropzone__text">Glissez-déposez une image ou cliquez pour sélectionner un fichier</span>
      <input type="file" id="image_file" name="image_file" required hidden>
    </label>
    <p id="file-name"></p>

    <input class= "button button--primary button--md" type="submit" value="Create Image">
</form>

</div>