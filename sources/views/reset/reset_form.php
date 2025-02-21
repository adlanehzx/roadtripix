<?php 
$title = 'Réinitialisation du mot de passe';
include __DIR__ . "/../layout/header.php";
?>

<div class="container container--center">
    <h1>Réinitialisation du mot de passe</h1>
    <p>Entrez votre adresse mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe.</p>

    <form class="input-container" method="POST" action="/reset-password">
        <div class="input-container">
            <label for="email">Adresse mail</label>
            <input class="input" type="email" id="email" name="email" placeholder="Adresse mail" required>
        </div>

        <div class="login-btn">
            <button type="submit" class="button button--primary button--md">Envoyer le lien</button>
        </div>
    </form>
</div>