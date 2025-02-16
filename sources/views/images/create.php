<form action="/images/<?= $groupId ?>" method="post" enctype="multipart/form-data">
    <label for="group_id">Group ID:</label>
    <input type="text" id="group_id" name="group_id" value="<?= $groupId ?>" required readonly><br>

    <label for="image_file">Upload Image:</label>
    <input type="file" id="image_file" name="image_file" required><br>

    <input type="submit" value="Create Image">
</form>