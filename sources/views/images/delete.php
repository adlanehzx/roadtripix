<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/water.css">
<form id="deleteForm" action="/images/<?php echo htmlspecialchars($groupId); ?>/delete/<?php echo htmlspecialchars($image->getId()); ?>" method="post">
    <input type="hidden" name="_method" value="DELETE">
    <p>Are you sure you want to delete this image?</p>
    <img src="<?= $image->getImageUrl() ?>" alt="<?= $image->getDescription() ?>">
    <button type="submit">Delete</button>
    <a href="/images">Cancel</a>
</form>