<?php

namespace App\Models;


use App\Core\QueryBuilder;
use App\Services\Factory\GroupInvitationFactory;

class GroupInvitation extends Model
{
    public const STATUS_PENDING = 'pending';
    public const STATUS_ACCEPTED = 'accepted';

    private ?int $id = null;
    private Group $group;
    private User $user;
    private ?string $token;
    private ?\DateTime $expiresAt;
    private ?string $status;


    public function isExpired(): bool
    {
        return $this->expiresAt !== null && $this->expiresAt < (new \DateTime());
    }

    public static function getGroupInvitationByToken(?string $token): ?GroupInvitation
    {
        if (empty($token)) {
            return null;
        }

        $qb = new QueryBuilder();

        $groupInvitation = $qb
            ->select(['*'])
            ->from('group_invitations')
            ->where('token', $token)
            ->fetch();

        if (empty($groupInvitation)) {
            return null;
        }

        return GroupInvitationFactory::createFromDatabase($groupInvitation);
    }


    protected function persist(): void
    {
        if ($this->id === null) {
            $this->freshPersist();
            return;
        }

        $this->updatePersist();
    }

    private function freshPersist(): void
    {
        $qb = new QueryBuilder();

        $invitationId = $qb
            ->insert('group_invitations', [
                'group_id' => $this->getGroup()->getId(),
                'user_id' => $this->getUser()->getId(),
                'token' => $this->getToken(),
                'expiresAt' => $this->getExpiresAt(),
                'status' => $this->getStatus(),
            ])
            ->execute();

        $this->setId($invitationId);

        return;
    }

    private function updatePersist(): void
    {
        $qb = new QueryBuilder();

        $qb
            ->update('group_invitations', [
                'group_id' => $this->getGroup()->getId(),
                'user_id' => $this->getUser()->getId(),
                'token' => $this->getToken(),
                'expiresAt' => $this->getExpiresAt(),
                'status' => $this->getStatus(),
            ])
            ->where('id', $this->id)
            ->execute();
        return;
    }


    #region Getters and Setters
    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function getGroup(): Group
    {
        return $this->group;
    }

    public function setGroup(Group $group): self
    {
        $this->group = $group;
        return $this;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): self
    {
        $this->user = $user;
        return $this;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): self
    {
        $this->token = $token;
        return $this;
    }

    public function getExpiresAt(): ?\DateTime
    {
        return $this->expiresAt;
    }

    public function setExpiresAt(?\DateTime $expiresAt): self
    {
        $this->expiresAt = $expiresAt;
        return $this;
    }

    public function getStatus(): ?string
    {
        return $this->status;
    }

    public function setStatus(?string $status): self
    {
        $this->status = $status;
        return $this;
    }

    #endregion
}
