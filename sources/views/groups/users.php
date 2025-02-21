<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer les Utilisateurs</title>
</head>

<?php
$title = 'Gérer les Utilisateurs';
include __DIR__ . "/../layout/header.php";
// TODO: modify width from scss - center the tds.
?>

<!DOCTYPE html>
<html lang="en">



<body>
    <div class="container container--center">
        <div class="user-management-table">
            <!-- Applique la classe ici -->
            <table>
                <thead>
                    <tr>
                        <th>L'ID</th>
                        <th>Pseudo</th>
                        <th>Prénom</th>
                        <th>Nom</th>
                        <th>Email</th>
                        <th>Pays</th>
                        <th>Virer</th>
                        <th>Lecture/Ecriture</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($groupUsers as $user): ?>
                    <?php if ($user->isSame($loggedUser)): ?>
                    <?php continue; ?>
                    <?php endif; ?>
                    <tr>
                        <td><?= htmlspecialchars($user->getId()) ?></td>
                        <td><?= htmlspecialchars($user->getUsername()) ?></td>
                        <td><?= htmlspecialchars($user->getFirstName()) ?></td>
                        <td><?= htmlspecialchars($user->getLastName()) ?></td>
                        <td><?= htmlspecialchars($user->getEmail()) ?></td>
                        <td><?= htmlspecialchars($user->getCountry()) ?></td>
                        <td><button class="btn btn-danger" onclick="removeUser(<?= $user->getId() ?>)">❌</button></td>
                        <td>
                            <?php if ($group->userHasWriteAcces($user)): ?>
                            <button class="btn btn-primary"
                                onclick="removeWriteAccess(<?= $user->getId() ?>)">🛑✏️</button>
                            <?php else: ?>
                            <button class="btn btn-primary" onclick="giveWriteAccess(<?= $user->getId() ?>)">📝</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php if (!empty($errors)) : ?>
        <div class="alert alert-danger">
            <?php if (is_array($errors)) : ?>
            <ul>
                <?php foreach ($errors as $error) : ?>
                <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
            <?php else : ?>
            <?= htmlspecialchars($errors) ?>
            <?php endif; ?>
        </div>
        <?php endif; ?>
    </div>

    <script>
    function removeUser(userId) {
        fetch(`/groups/<?= $group->getId() ?>/users/${userId}/remove`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Failed to remove user');
            }
        });
    }

    function giveWriteAccess(userId) {
        fetch(`/groups/<?= $group->getId() ?>/users/${userId}/giveWrite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Failed to give write access');
            }
        });
    }

    function removeWriteAccess(userId) {
        fetch(`/groups/<?= $group->getId() ?>/users/${userId}/removeWrite`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            }
        }).then(response => {
            if (response.ok) {
                location.reload();
            } else {
                alert('Failed to remove write access');
            }
        });
    }
    </script>
</body>

</html>