<?php 
$title = 'Réinitialisation du mot de passe';
include __DIR__ . "/../layout/header.php";
?>

<div class="container">
    
        <h2>Réinitialisation du mot de passe</h2>
           <p> Entrez votre adresse mail ci-dessous et nous vous enverrons un lien pour réinitialiser votre mot de passe.
        </p>

        <form class="ResetForm" method="POST" action="/reset/reset-form">
            
                
            
        <div class="input-container">
                <input type="password" id="password" name="password"
                       class="input <?= isset($errors['password']) ? 'input--error' : '' ?>"
                       placeholder="Mot de passe" required>
            </div>
            <?php if (!empty($errors['password'])): ?>
                <ul class="error-messages">
                    <?php foreach ($errors['password'] as $message): ?>
                        <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="input-container">
                <input type="password" id="passwordConfirm" name="passwordConfirm"
                       class="input <?= isset($errors['passwordConfirm']) ? 'input--error' : '' ?>"
                       placeholder="Confirmez le mot de passe" required>
            </div>
            <?php if (!empty($errors['passwordConfirm'])): ?>
                <ul class="error-messages">
                    <?php foreach ($errors['passwordConfirm'] as $message): ?>
                        <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>
        </form>
    
</div>