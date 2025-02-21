<?php
$title = 'Delete Group';
include __DIR__ . "/../layout/header.php";
?>
<div class="container container--center">


    <form id="deleteForm"
        action="/images/<?php echo htmlspecialchars($groupId); ?>/delete/<?php echo htmlspecialchars($image->getId()); ?>"
        method="post">
        <input type="hidden" name="_method" value="DELETE">
        <p>Êtes-vous sûr de vouloir supprimer cette image ?</p>
        <img src="<?= $image->getImageUrl() ?>" alt="<?= $image->getDescription() ?>">
        <br />
        <button class="button button--danger button--md" type="submit">Delete</button>
        <a class="button button--white button--md" href="/">Cancel</a>
    </form>

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