<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
<form id="deleteForm" action="/groups/<?php echo htmlspecialchars($groupId); ?>/delete" method="post">
    <input type="hidden" name="_method" value="DELETE">
    <p>Are you sure you want to delete this group?</p>
    <button type="submit">Delete</button>
    <a href="/groups">Cancel</a>
</form>