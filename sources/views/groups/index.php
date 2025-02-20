<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Aperçu du groupe</title>
</head>

<?php
$title = 'Aperçu du groupe';
include __DIR__ . "/../layout/header.php";
?>

<body>
    <div class="container">
        <section>
            <div class="card">
                <h1>L'aperçu d'un groupe</h1>
                <h2><em>Renseignement du groupe :</em></h2>
                <p><strong>Nom du groupe: </strong> <?= $group->getName() ?></p>
                <p><strong>Id du groupe: </strong><?= $group->getId() ?></p>
                <p><strong>Date de création du groupe:</strong> <?= $group->getCreatedAt() ?></p>
            </div>
            <h2><em>Utilisateurs du groupe :</em></h2>
            <ul>
                <?php foreach ($groupUsers as $user): ?>
                    <li class="card">
                        <?= $user->getUsername() ?> (<?= $user->getEmail() ?>)
                        <?php if ($user->owns($group)): ?>
                            <span title='possède le groupe'>👑</span>
                        <?php endif; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
            <h2><em>Les images du groupe :</em></h2>
            <?php if (empty($groupImages)): ?>
                <p>Aucune image pour le moment.</p>
            <?php endif; ?>
            <div class="gallery">
                <?php foreach ($groupImages as $image): ?>
                    <div class="gallery__item"
                        onclick="openModal('<?= $image->getImageUrl() ?>', '<?= $image->getDescription() ?>')">
                        <img src="<?= $image->getImageUrl() ?>" alt="<?= $image->getDescription() ?>">
                    </div>


                    <div id="imageModal" class="modal" onclick="closeModal()">
                        <div class="modal__content" onclick="event.stopPropagation();">

                            <div class="modal__content__image">
                                <img id="modalImage" src="" alt="Image agrandie">
                            </div>

                            <div class="modal__content__info">
                                <p id="modalDescription"></p>
                                <div class="buttons">
                                    <button class="button button--primary close" onclick="closeModal()">Fermer</button>
                                    <?php if ($image->ownedBy($currentUser) || $currentUser->owns($group)): ?>
                                        <a
                                            id="deleteImageBtn"
                                            class="button button--danger"
                                            href="/images/<?= $group->getId() ?>/delete/<?= $image->getId() ?>">Supprimer</a>
                                    <?php endif; ?>
                                    <button class="button button--primary">Partager</button>
                                </div>
                            </div>

                        </div>
                    </div>

                <?php endforeach; ?>
            </div>



            <h2><em>Ajouter une image :</em></h2>
            <a class="button button--primary button--md" href="/images/<?= $group->getId() ?>/create">Ajouter une
                image</a>

            <h2><em>Supprimer le groupe</em></h2>
            <a class="button button--danger button--md" href="/groups/<?= $group->getId() ?>/delete">Delete</a>



    </div>
</body>

</html>