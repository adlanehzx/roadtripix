<?php 
$title = 'Réinitialisation du mot de passe';
include __DIR__ . "/../layout/header.php";
?>

<div class="container">
    <h2>Réinitialisation du mot de passe</h2>
    <form class="ResetForm" method="POST"
        action="/reset-password/<?= htmlspecialchars($token) ?>/<?= urlencode($email) ?>">
        <div class="input-container">
            <input type="password" id="password" name="password" class="input" placeholder="Mot de passe" required>
        </div>
        <div class="input-container">
            <input type="password" id="passwordConfirm" name="passwordConfirm" class="input"
                placeholder="Confirmez le mot de passe" required>
        </div>
        <button type="submit" class="button button--primary button--md">Réinitialiser le mot de passe</button>
    </form>
</div>