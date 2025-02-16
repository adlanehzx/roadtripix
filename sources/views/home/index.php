<style>
    .success {
        color: green;
    }
</style>
<h1>Welcome home</h1>

<p>logged in as <strong><em> <?= $username ?></em></strong> with id <strong><em><?= $userId ?></em></strong></p>


<h2>Les groupes dont tu es membre :</h2>
<ul>
    <?php foreach ($groups as $group): ?>
        <li>
            Nom : <em><?= htmlspecialchars($group->getName()) ?></em>
            son ID : <em><?= htmlspecialchars($group->getId()) ?></em>
            crée le : <em><?= htmlspecialchars($group->getCreatedAt()) ?></em>
            <strong>par</strong> <?= $group->getOwner()->getUsername() ?>
            - <a href="/groups/<?= $group->getId() ?>">lien au groupe</a>
        </li>
    <?php endforeach; ?>
</ul>

<?php if (isset($success)): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>