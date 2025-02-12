<?php include __DIR__ . '/../layout/header.php'; ?>

<h1>Liste des Groupes</h1>

<?php if (empty($groups)): ?>
    <p>Aucun groupe trouvé.</p>
<?php else: ?>
    <ul>
        <?php foreach ($groups as $group): ?>
            <li>
                <a href="/groups/<?= htmlspecialchars($group->getId()) ?>">
                    <?= htmlspecialchars($group->getName()) ?>
                </a> - Créé le <?= htmlspecialchars($group->getCreatedAt()) ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<a href="/groups/create">Créer un Groupe</a>
