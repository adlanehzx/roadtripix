<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<head>
    <link rel="stylesheet" href="/dist/gestion-d-images-php-project.css" />
    <script src="/dist/gestion-d-images-php-project.umd.js"></script>
</head>

<header>
    <h1>Bienvenue sur RoadTripPix 📸</h1>
    <p>Partage tes souvenirs de voyage avec tes amis, en toute simplicité.</p>
    <nav>
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/logout">Logout</a>
            <a href="/my_groups">My Groups</a>
            <a href="/">Home</a>

        <?php else: ?>
            <a href="/login">Login</a>
            <a href="/register">Register</a>
        <?php endif; ?>

        <button id="theme-toggle" class="button button--secondary">Changer de thème</button>


        <div id="dropzone" class="dropzone">
            <div class="dropzone__text">Glissez-déposez un fichier ici ou cliquez pour sélectionner</div>
            <input type="file" id="fileInput" hidden>
        </div>

        <button id="theme-toggle">Mode </button>

    </nav>

</header>