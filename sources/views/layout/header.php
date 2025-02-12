<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

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
    </nav>
    
</header>

    