<?php

namespace App\Models;

use App\Services\Factory\ImageExternalLinkFactory;

use App\Core\QueryBuilder;
use PDO;

class ImageExternalLink extends Model
{
    private ?int $id = null;
    private ?Image $image;
    private ?string $token;
    private ?\DateTime $expiresAt;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'image_external_link';
    }

    public function getLink(): ?string
    {
        if (empty($token)) {
            return null;
        }
        return "/external-images/show/" . $this->getToken();
    }

    public function isExpired(): bool
    {
        return $this->expiresAt !== null && $this->expiresAt < (new \DateTime());
    }

    public static function getImageExternalLinkByToken(?string $token): ?ImageExternalLink
    {
        if (empty($token)) {
            return null;
        }

        $qb = new QueryBuilder();

        $imageExternalLink = $qb
            ->select(['*'])
            ->from('image_external_link')
            ->where('token', $token)
            ->fetch();

        if (empty($imageExternalLink)) {
            return null;
        }

        return ImageExternalLinkFactory::createFromDatabase($imageExternalLink);
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

        $linkId = $qb
            ->insert('image_external_link', [
                'image_id' => $this->getImage()->getId(),
                'token' => $this->getToken(),
                'expires_at' => $this->getExpiresAt()->format('Y-m-d H:i:s'),
            ])
            ->execute();

        $this->setId($linkId);

        return;
    }

    private function updatePersist(): void
    {
        $qb = new QueryBuilder();

        $qb
            ->update('image_external_link', [
                'image_id' => $this->getImage()->getId(),
                'token' => $this->getToken(),
                'expires_at' => $this->getExpiresAt()->format('Y-m-d H:i:s'),
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

    public function getImage(): ?Image
    {
        return $this->image;
    }

    public function setImage(?Image $image): self
    {
        $this->image = $image;
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
    #endregion


}
