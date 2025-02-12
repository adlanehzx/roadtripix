<?php
namespace App\Models;

use App\Core\QueryBuilder;

class Invitation extends Model
{
    private int $id;
    private int $groupId;
    private string $email;
    private string $token;
    private string $expiresAt;
    private string $status;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'invitations';
    }

    // Implémentation de la méthode persist
    protected function persist()
    {
        // Assure-toi que l'objet soit prêt pour l'insertion
        $qb = new QueryBuilder();
        $qb->insert($this->tableName, [
            'group_id' => $this->groupId,
            'email' => $this->email,
            'token' => $this->token,
            'expires_at' => $this->expiresAt,
            'status' => $this->status,
        ])->execute();
    }

    // Crée une invitation et la sauvegarde
    public function createInvitation(int $groupId, string $email): string
    {
        $this->groupId = $groupId;
        $this->email = $email;
        $this->token = bin2hex(random_bytes(32));
        $this->expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
        $this->status = 'pending';

        // Appelle la méthode persist pour enregistrer les données
        $this->save();

        return $this->token;
    }

    // Récupère une invitation par son token
    public function getInvitationByToken(string $token): ?array
    {
        $qb = new QueryBuilder();
        $invitation = $qb->select(['*'])
            ->from($this->tableName)
            ->where('token', $token)
            ->where('status', 'pending')
            ->where('expires_at > NOW()')
            ->fetch();

        return $invitation ?: null;
    }

    // Accepte une invitation et ajoute l'utilisateur au groupe
    public function acceptInvitation(string $token, int $userId): bool
    {
        $invitation = $this->getInvitationByToken($token);
        if (!$invitation) return false;

        // Ajoute l'utilisateur au groupe
        $qb = new QueryBuilder();
        $qb->insert('user_groups', [
            'user_id' => $userId,
            'group_id' => $invitation['group_id'],
        ])->execute();

        // Change le statut de l'invitation en "acceptée"
        $qb->update('invitations', ['status' => 'accepted'])
            ->where('token', $token)
            ->execute();

        return true;
    }
}
