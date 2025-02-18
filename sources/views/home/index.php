<style>
    .success {
        color: green;
    }
</style>

<?php $title = 'Home';
include __DIR__ . "/../layout/header.php";
?>
<div class= "container"> 
<h1>Welcome home</h1>

<p>logged in as <strong><em> <?= $username ?></em></strong> </p>

<h2 >créer un groupe</h2>

<a class= "button button--primary button--md" href="/groups/create">Créer un groupe</a>

<h2>Les groupes dont tu es membre :</h2>
<ul>
    <?php foreach ($groups as $group): ?>
        <li class="grid">
            Nom : <em><?= htmlspecialchars($group->getName()) ?></em>
            son ID : <em><?= htmlspecialchars($group->getId()) ?></em>
            crée le : <em><?= htmlspecialchars($group->getCreatedAt()) ?></em>
            <strong>par</strong> <?= $group->getOwner()->getUsername() ?>
            - <a class= "button button--primary button--md" href="/groups/<?= $group->getId() ?>">lien au groupe</a>
        </li>
    <?php endforeach; ?>
</ul>

<?php if (isset($success)): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>

</div>