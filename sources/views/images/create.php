<form action="/images/create" method="post">
    <label for="name">Name:</label>
    <input type="text" id="name" name="name" required><br>

    <label for="image_url">Image URL:</label>
    <input type="text" id="image_url" name="image_url" required><br>

    <label for="description">Description:</label>
    <textarea id="description" name="description"></textarea><br>

    <label for="user_id">User ID:</label>
    <input type="number" id="user_id" name="user_id" required><br>

    <label for="group_id">Group ID:</label>
    <input type="number" id="group_id" name="group_id" value="<?= $groupId ?>" required readonly><br>

    <input type="submit" value="Create Image">
</form>