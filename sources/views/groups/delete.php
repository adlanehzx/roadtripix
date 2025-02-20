<?php 
$title = 'Delete Group';
include __DIR__ . "/../layout/header.php";
?>
<div class="container">
    <form id="deleteForm" action="/groups/<?php echo htmlspecialchars($groupId); ?>/delete" method="post">
        <input type="hidden" name="_method" value="DELETE">
        <p>Are you sure you want to delete this group?</p>
        <button class="button button--danger button--md" type="submit">Delete</button>
        <a class="button button--white button--md" href="/">Cancel</a>
    </form>

</div>