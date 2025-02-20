<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <title>Lien expiré</title>
</head>
<?php include __DIR__ . "/../layout/header.php"; ?>

<body>
    <div class="container">
        <h1>Lien expiré</h1>
        <p>Le lien que vous avez utilisé pour réinitialiser votre mot de passe a expiré.</p>
        <p>Veuillez demander un nouveau lien de réinitialisation.</p>
        <a href="/reset-password" class="button button--primary">Demander un nouveau lien</a>
    </div>

    <?php if (isset($errors) && count($errors) > 0): ?>
    <div class="error-messages">
        <?php foreach ($errors as $error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</body>

</html>