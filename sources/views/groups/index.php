<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu du groupe</title>
</head>

<?php
include __DIR__ . "/../layout/header.php";
?>

<body>
    <h1>L'aperçu d'un groupe</h1>
    <p>Nom du groupe: <?= $group->getName() ?></p>
    <p>Id du groupe: <?= $group->getId() ?></p>
    <p>Date de création du groupe: <?= $group->getCreatedAt() ?></p>
    <h2>Membres du groupe</h2>

    

    <h2>Inviter un membre</h2>


    <a href="/invite/<?= $group->getId() ?>">Inviter un membre</a>



    <h2>Images du groupe</h2>
    <a href="/images/<?= $group->getId() ?>">Voir les images du groupe</a>
    <h2>Ajouter une image</h2>
    <a href="/images/<?= $group->getId() ?>/create">Ajouter une image</a>
</body>

</html>