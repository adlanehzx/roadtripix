<?php 
$title = 'Home';
include __DIR__ . "/../layout/header.php";
?>

<div class="container container--center">
    <h1>Welcome home</h1>

    <p><strong><em> <?= htmlspecialchars($username) ?></em></strong></p>

    <h2>Créer un groupe</h2>

    <a class="button button--primary " href="/groups/create">Créer un groupe</a>

    <h2>Les groupes dont tu es membre :</h2>
    <?php if (empty($groups)): ?>
    <p>Tu n'es membre d'aucun groupe pour le moment.</p>
    <?php endif; ?>

    <div class="card-container">
        <?php foreach ($groups as $group): ?>
        <div class="card card--group-preview">
            <div class="card-header">
                <h3><?= htmlspecialchars($group->getName()) ?></h3>
                <p class="group-id">ID : <strong><?= htmlspecialchars($group->getId()) ?></strong></p>
            </div>
            <div class="card-body">
                <p><strong>Créé le :</strong> <em><?= htmlspecialchars($group->getCreatedAt()) ?></em></p>
                <p><strong>Propriétaire :</strong> <?= htmlspecialchars($group->getOwner()->getUsername()) ?></p>
            </div>
            <div class="card-footer">
                <a class="button button--primary " href="/groups/<?= $group->getId() ?>">Voir le groupe</a>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php if (is_array($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php else : ?>
            <?= htmlspecialchars($errors) ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

</div>