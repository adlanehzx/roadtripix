<html lang="fr" data-theme="light">



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
</body>



</html>