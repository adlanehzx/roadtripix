<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="/dist/gestion-d-images-php-project.css">
    <script src="/dist/gestion-d-images-php-project.mjs" defer></script>
</head>

<div class="container--header">
    <header class="header">
        <nav class="navbar">
            <div class="navbar__logo">
                <span class="navbar__logo__text">RoadTriPix *</span>
            </div>
            <div class="navbar__links">
                <?php if (isset($_SESSION['user_id'])): ?>
                <a href="/" class="navbar__link">Home</a>
                <a href="/logout" class="navbar__link">Logout</a>
                <?php else: ?>
                <a href="/login" class="navbar__link">Login</a>
                <a href="/register" class="navbar__link">Register</a>
                <?php endif; ?>
            </div>

        </nav>
    </header>
</div>