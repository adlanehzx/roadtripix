<!-- view/invite/invite.php -->

<form action="/invitations/send" method="POST">
    <h2>Envoyer une invitation</h2>
    <div>
        <label for="group_id">ID du groupe :</label>
        <input type="number" id="group_id" name="group_id" value="<?= htmlspecialchars($groupId) ?>" required readonly>
        <label for="email">Email de l'utilisateur :</label>
        <input type="email" id="email" name="email" required placeholder="Email de l'utilisateur à inviter">
    </div>
    <div>
        <button type="submit">Envoyer l'invitation</button>
    </div>
</form>
