<!DOCTYPE html>
<html lang="fr">

<?php
$title = "Register";
include __DIR__ . "/../layout/header.php";
?>

<body>
    <main>
        <div class="container">
            <h1>S'inscrire</h1>
        <form action="/register" method="POST">
            <div class="input-container">
                <input type="text" id="username" name="username"
                       class="input <?= isset($errors['username']) ? 'input--error' : '' ?>"
                       value="<?= htmlspecialchars($_POST['username'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       placeholder="Nom d'utilisateur" required>
            </div>
            <?php if (!empty($errors['username'])): ?>
                <ul class="error-messages">
                    <?php foreach ($errors['username'] as $message): ?>
                        <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="input-container">
                <input type="email" id="email" name="email"
                       class="input <?= isset($errors['email']) ? 'input--error' : '' ?>"
                       value="<?= htmlspecialchars($_POST['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       placeholder="Email" required>
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

            <div class="input-container">
                <input type="text" id="firstname" name="firstname"
                       class="input <?= isset($errors['firstname']) ? 'input--error' : '' ?>"
                       value="<?= htmlspecialchars($_POST['firstname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       placeholder="Prénom" required>
            </div>
            <?php if (!empty($errors['firstname'])): ?>
                <ul class="error-messages">
                    <?php foreach ($errors['firstname'] as $message): ?>
                        <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="input-container">
                <input type="text" id="lastname" name="lastname"
                       class="input <?= isset($errors['lastname']) ? 'input--error' : '' ?>"
                       value="<?= htmlspecialchars($_POST['lastname'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       placeholder="Nom" required>
            </div>
            <?php if (!empty($errors['lastname'])): ?>
                <ul class="error-messages">
                    <?php foreach ($errors['lastname'] as $message): ?>
                        <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <div class="input-container">
                <input type="text" id="country" name="country"
                       class="input <?= isset($errors['country']) ? 'input--error' : '' ?>"
                       value="<?= htmlspecialchars($_POST['country'] ?? '', ENT_QUOTES, 'UTF-8') ?>"
                       placeholder="Pays" required>
            </div>
            <?php if (!empty($errors['country'])): ?>
                <ul class="error-messages">
                    <?php foreach ($errors['country'] as $message): ?>
                        <li><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></li>
                    <?php endforeach; ?>
                </ul>
            <?php endif; ?>

            <button class="button button--primary button--md" type="submit">S'inscrire</button>
        </form>
        </div>
    </main>
</body>
</html>
