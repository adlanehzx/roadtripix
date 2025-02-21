<?php
$title = "Login";
include __DIR__ . "/../layout/header.php";
?>

<div class="container container--center">
    <h1>Login</h1>
    <form action="/login" method="POST">
        <div class="input-container">
            <input type="email" id="email" name="email"
                class="input <?= isset($errors['email']) ? 'input--error' : '' ?>"
                value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" placeholder="Votre email"
                required>
        </div>
        <?php if (!empty($errors['email'])): ?>
        <ul class="error-messages">
            <?php foreach ($errors['email'] as $message): ?>
            <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>

        <div class="input-container">
            <input type="password" id="password" name="password"
                class="input <?= isset($errors['password']) ? 'input--error' : '' ?>" placeholder="Votre mot de passe"
                required>
        </div>
        <?php if (!empty($errors['password'])): ?>
        <ul class="error-messages">
            <?php foreach ($errors['password'] as $message): ?>
            <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
            <?php endforeach; ?>
        </ul>
        <?php endif; ?>
        <div class="login-btn">

            <button class="button button--primary button-md button-center" type="submit">Login</button>
            <a class="button button--primary button-md" href="/reset-password">Reset Password</a>

        </div>
    </form>
</div>