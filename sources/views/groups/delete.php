<?php
$title = 'Delete Group';
include __DIR__ . "/../layout/header.php";
?>
<div class="container container--center">
    <form id="deleteForm" action="/groups/<?php echo htmlspecialchars($groupId); ?>/delete" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <p>Êtes-vous sûr de vouloir supprimer ce groupe ?</p>
        <button class="button button--danger button--md" type="submit">Supprimer</button>
        <a class="button button--white button--md" href="/">Annuler</a>
    </form>
</div>