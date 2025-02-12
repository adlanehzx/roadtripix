<form action="/images/<?= $groupId ?>" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="image_url">Image URL:</label>
    <input type="text" id="image_url" name="image_url" required><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea><br>

    <label for="group_id">Group ID:</label>
    <input type="text" id="group_id" name="group_id" value="<?= $groupId ?>" required readonly><br>

    <input type="submit" value="Create Image">
</form>