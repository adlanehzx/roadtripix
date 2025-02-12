
<form action="/register" method="POST">
    <label for="username">Nom d'utilisateur:</label>
    <input type="text" id="username" name="username" value="<?= $_POST['username'] ?? '' ?>" required>
    <?php if (isset($errors['username'])): ?>
        <ul>
            <?php foreach ($errors['username'] as $message): ?>
                <li style="color: red;"><?= $message ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
    <?php if (isset($errors['email'])): ?>
        <ul>
            <?php foreach ($errors['email'] as $message): ?>
                <li style="color: red;"><?= $message ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <label for="password">Mot de passe:</label>
    <input type="password" id="password" name="password" required>
    <?php if (isset($errors['password'])): ?>
        <ul>
            <?php foreach ($errors['password'] as $message): ?>
                <li style="color: red;"><?= $message ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <label for="passwordConfirm">Confirmer le mot de passe :</label>
    <input type="password" id="passwordConfirm" name="passwordConfirm" required>
    <?php if (isset($errors['passwordConfirm'])): ?>
        <ul>
            <?php foreach ($errors['passwordConfirm'] as $message): ?>
                <li style="color: red;"><?= $message ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <label for="firstname">Prénom :</label>
    <input type="text" id="firstname" name="firstname" value="<?= $_POST['firstname'] ?? '' ?>" required>
    <?php if (isset($errors['firstname'])): ?>
        <ul>
            <?php foreach ($errors['firstname'] as $message): ?>
                <li style="color: red;"><?= $message ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <label for="lastname">Nom :</label>
    <input type="text" id="lastname" name="lastname" value="<?= $_POST['lastname'] ?? '' ?>" required>
    <?php if (isset($errors['lastname'])): ?>
        <ul>
            <?php foreach ($errors['lastname'] as $message): ?>
                <li style="color: red;"><?= $message ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <label for="country">Pays :</label>
    <input type="text" id="country" name="country" value="<?= $_POST['country'] ?? '' ?>" required>
    <?php if (isset($errors['country'])): ?>
        <ul>
            <?php foreach ($errors['country'] as $message): ?>
                <li style="color: red;"><?= $message ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <button type="submit">S'inscrire</button>
</form>