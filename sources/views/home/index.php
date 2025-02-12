<style>
    .success {
        color: green;
    }
</style>
<h1>Welcome home</h1>

<p>logged in as <strong><em> <?= $username ?></em></strong> with id <strong><em><?= $userId ?></em></strong></p>

<?php if (isset($success)): ?>
    <p class="success"><?= htmlspecialchars($success) ?></p>
<?php endif; ?>