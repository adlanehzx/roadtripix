
<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
</head>

<body>
    <form action="/login" method="POST">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?= $_POST['email'] ?? '' ?>" required>
        <?php if (isset($errors['email'])): ?>
            <ul>
                <?php foreach ($errors['email'] as $message): ?>
                    <li style="color: red;"><?= $message ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <?php if (isset($errors['password'])): ?>
            <ul>
                <?php foreach ($errors['password'] as $message): ?>
                    <li style="color: red;"><?= $message ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <button type="submit">Login</button>
    </form>
</body>

</html>