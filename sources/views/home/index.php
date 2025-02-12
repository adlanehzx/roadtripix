

<head>
    <link rel="stylesheet" href="http://localhost:5173/dist/gestion-d-images-php-project.css" />
    <script src="http://localhost:5173/dist/gestion-d-images-php-project.js"></script>
  </head>

<?php
$title = "Accueil";
include __DIR__ . "/../layout/header.php";
?>
<?php if (isset($_SESSION['user_id'])): ?>
    <section>
        <h2>Mes groupes</h2>
        <a href="/my_groups">Voir mes groupes</a>
    </section>
    <section>
        <h2>Nouveau groupe</h2>
        <a href="/groups/create">Crée un groupe</a>
    </section>
<?php else: ?>
    <section>
        <h2>Comment ça marche ?</h2>
        <ul>
            <li>📌 <strong>Crée un compte</strong> en quelques secondes.</li>
            <li>👥 <strong>Rejoins un groupe</strong> et invite tes amis.</li>
            <li>📸 <strong>Partage tes photos</strong> et revivez vos souvenirs.</li>
        </ul>
    </section>
<?php endif; ?>


    




<?php include __DIR__ . "/../layout/footer.php"; ?>

    <section>
        <h1>.spinner</h1>
        <div class="spinner"></div>
        <div class="spinner spinner--purple"></div>
        <div class="spinner spinner--red spinner--lg"></div>
    </section>