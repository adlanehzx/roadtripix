<?php
include __DIR__ . "/../layout/header.php";
?>

<body>

    <div class="container container--center">

        <h2>Inviter un membre</h2>

        <?php if (isset($errors) && !empty($errors)): ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($errors) ?>
        </div>
        <?php endif; ?>


        <form class="input-container" method="POST" action="/invite/<?= $groupId ?>">

            <label for="email">Adresse mail</label>
            <input class="input" type="email" id="email" placeholder="Adresse mail" name="guestEmail" required>

            <button type="submit" class="button button--primary button--md ">Envoyer l'invitation</button>

        </form>

    </div>


</body>