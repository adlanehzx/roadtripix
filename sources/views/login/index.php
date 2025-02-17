<<<<<<< HEAD
<!DOCTYPE html>
<html lang="fr">
=======
<?php
require_once __DIR__ . '/../base.php';
?>
>>>>>>> 89b6c57c4cdc193027d3ae22987433fb97290f84

<?php
$title = "Login";
include __DIR__ . "/../layout/header.php";
?>
<body>
    <main>
        <form action="/login" method="POST">
            <div class="input-container">
                <input type="email" id="email" name="email" 
                       class="input <?= isset($errors['email']) ? 'input--error' : '' ?>" 
                       value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" 
                       placeholder="Votre email" required>
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
                       class="input <?= isset($errors['password']) ? 'input--error' : '' ?>" 
                       placeholder="Votre mot de passe" required>
            </div>
            <?php if (!empty($errors['password'])): ?>
                <ul class="error-messages">
                    <?php foreach ($errors['password'] as $message): ?>
                        <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <button class="button button--primary button--md" type="submit">Login</button>
        </form>
    </main>
</body>
</html>
