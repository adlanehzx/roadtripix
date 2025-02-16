<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu du groupe</title>
</head>

<body>
    <h1>L'aperçu d'un groupe</h1>
    <h2><em>Renseignement du groupe :</em></h2>
    <p><strong>Nom du groupe: </strong> <?= $group->getName() ?></p>
    <p><strong>Id du groupe: </strong><?= $group->getId() ?></p>
    <p><strong>Date de création du groupe:</strong> <?= $group->getCreatedAt() ?></p>
    <h2><em>Utilisateurs du groupe :</em></h2>
    <ul>
        <?php foreach ($groupUsers as $user): ?>
            <li>
                <?= $user->getUsername() ?> (<?= $user->getEmail() ?>)
                <?php if ($user->owns($group)): ?>
                    <span title='possède le groupe'>👑</span>
                <?php endif; ?>
            </li>
        <?php endforeach; ?>
    </ul>
    <h2><em>Les images du groupe :</em></h2>
    <ul>
        <?php foreach ($groupImages as $image): ?>
            <li>
                <a href="<?= $image->getImageUrl() ?>"><em><?= $image->getDescription() ?></em></a> - <strong>uploadé par</strong> <em> <?= $image->getUser()->getUsername() ?></em> <strong>le</strong> <em><?= $image->getUploadedAt() ?></em>
            </li>
        <?php endforeach; ?>
    </ul>
</body>

</html>