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
    <div class="container container--center">
        <section>
            <div class="card card--group-preview">
                <h1 class="card-header">L'aperçu d'un groupe</h1>
                <div class="card-body">
                    <h2><em>Renseignement du groupe :</em></h2>
                    <p><strong>Nom du groupe: </strong> <?= $group->getName() ?></p>
                    <p><strong>Id du groupe: </strong><?= $group->getId() ?></p>
                    <p><strong>Date de création du groupe:</strong> <?= $group->getCreatedAt() ?></p>
                </div>
            </div>

            <?php if ($loggedUser->owns($group)): ?>
                <a href="/groups/<?= $group->getId() ?>/users" class="button button--primary button--md">Gérer les
                    utilisateurs 👥⚙️</a>
                <a href="/invite/<?= $group->getId() ?>" class="button button--primary button--md">Inviter des membres
                    📩</a>
            <?php endif; ?>

            <h2><em>Les images du groupe :</em></h2>
            <div class="gallery">
                <?php if (empty($groupImages)): ?>
                    <p>Aucune image pour le moment.</p>
                <?php endif; ?>
                <?php foreach ($groupImages as $image): ?>
                    <article class="gallery__item"
                        onclick="openModal('<?= $image->getImageUrl() ?>', '<?= $image->getDescription() ?>', '<?= $image->getId() ?>' , '<?= $group->getId() ?>')">
                        <img src="<?= $image->getImageUrl() ?>" alt="<?= $image->getDescription() ?>">
                    </article>
                <?php endforeach; ?>
            </div>
            <?php if (!empty($groupImages)): ?>
                <div id="imageModal" class="modal" onclick="closeModal()">
                    <div class="modal__content" onclick="event.stopPropagation();">
                        <div class="modal__content__image">
                            <img id="modalImage" src="" alt="Image agrandie">
                        </div>
                        <div class="modal__content__info">
                            <p id="modalDescription"></p>
                            <div class="buttons">
                                <button class="button button--primary close" onclick="closeModal()">Fermer</button>
                                <?php if ($image->ownedBy($loggedUser) || $loggedUser->owns($group)): ?>
                                    <a id="deleteImageBtn" class="button button--danger"
                                        href="/images/<?= $group->getId() ?>/delete/<?= $image->getId() ?>">Supprimer</a>
                                <?php endif; ?>
                                <button id="share-button" class="button button--primary"
                                    onclick="">Partager</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ($group->userHasWriteAcces($loggedUser)): ?>
                <h2><em>Ajouter une image :</em></h2>
                <a class="button button--primary button--md" href="/images/<?= $group->getId() ?>/create">
                    Ajouter une image
                </a>
            <?php endif; ?>


            <?php if ($loggedUser->owns($group)): ?>
                <h2><em>Supprimer le groupe</em></h2>
                <a class="button button--danger button--md" href="/groups/<?= $group->getId() ?>/delete">Delete</a>
            <?php endif; ?>

        </section>


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
</body>


<script>
    function shareImage(imageId) {
        fetch(`/external-images/create/${imageId}`, {
                method: 'POST',
            })
            .then(response => response.json())
            .then(data => {
                if (data.link) {
                    navigator.clipboard.writeText(data.link).then(() => {
                        alert('Le lien genéré est copié dans votre presse-papier : ' + data.link);
                    }).catch(err => {
                        alert('Une erreur est survenue ! ' + err);
                    });
                } else {
                    alert('Une erreur est survenue : ', data.error);
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>



</html>