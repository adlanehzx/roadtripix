<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu du groupe</title>
</head>

<body>
    <h1>L'aperçu d'un groupe</h1>

    <p>Nom du groupe: <?= $group->getName() ?></p>
    <p>Id du groupe: <?= $group->getId() ?></p>
    <p>Date de création du groupe: <?= $group->getCreatedAt() ?></p>
</body>

</html>