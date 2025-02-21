<!DOCTYPE html>
<html lang="en">
<?php   
    $title = 'Create Group';
    include __DIR__ . "/../layout/header.php";
    ?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Group</title>
</head>

<body>
    <div class="container container--center">
        <h1>Create Group</h1>
        <form class="input-container" action="/groups" method="POST">
            <label for="name">Group Name:</label>
            <input class="input" type="text" id="name" name="name" required>
            <div class="login-btn">
                <button class="button button--primary button--md" type="submit">Create</button>
            </div>
        </form>
    </div>
</body>

</html>