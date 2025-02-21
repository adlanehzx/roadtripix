<?php
$title = 'Créer une image';
include __DIR__ . "/../layout/header.php";
?>


<body>
    <div class="container container--center">
        <h1>Vous avez été ajouté avec succès. Vous serez redirigé vers la page de connexion dans 5 secondes.</h1>;
    </div>

</body>

<script>
setTimeout(function() {
    window.location.href = "/login";
}, 5000);
</script>';