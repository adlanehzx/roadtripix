<?php

namespace App\Models;

use App\Core\QueryBuilder;
use DateTime;
use PDO;

class Image extends Model
{
    private ?int $id = null;
    private $imageUrl;
    private $description;
    private User $user;
    private Group $group;
    private ?string $uploadedAt = null;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'images';
    }

    protected function persist(): void
    {
        if ($this->getId() === null) {
            $this->freshPersist();
            return;
        }

        $this->updatePersist();
    }

    private function freshPersist(): bool
    {
        $qb = new QueryBuilder();

        $insertedImageId = $qb
            ->insert('images', [
                'image_file_name' => $this->getImageUrl(),
                'description' => $this->getDescription(),
                'user_id' => $this->getUser()->getId(),
                'group_id' => $this->getGroup()->getId(),
                'uploaded_at' => $this->getUploadedAt(),
            ])
            ->execute();

        $this->setId($insertedImageId);
        return true;
    }

    private function updatePersist(): bool
    {
        $qb = new QueryBuilder();

        $qb
            ->update('images', [
                'image_file_name' => $this->getImageUrl(),
                'description' => $this->getDescription(),
            ])
            ->where('id', $this->getId(), true)
            ->execute();

        return true;
    }

    public function belongsTo(?Group $group): bool
    {
        return $this->getGroup()->getId() === $group?->getId();
    }

    public function ownedBy(?User $user): bool
    {
        return $this->getUser()->getId() === $user?->getId();
    }

    public static function find($id): ?Image
    {
        $queryBuilder = new QueryBuilder();
        $image = $queryBuilder
            ->select(['*'])
            ->from('images')
            ->where('id', $id)
            ->fetch();

        if (empty($image)) {
            return null;
        }

        return (new Image())
            ->setId($image['id'])
            ->setImageUrl($image['image_file_name'])
            ->setDescription($image['description'])
            ->setUser(User::find($image['user_id']))
            ->setGroup(Group::find($image['group_id']))
            ->setUploadedAt($image['uploaded_at'])
        ;
    }

    public function delete(): void
    {
        $qb = new QueryBuilder();

        $qb
            ->delete('images')
            ->where('id', $this->getId())
        ;

        $qb->execute();
    }

    #region Getters / Setters
    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getImageUrl(): ?string
    {
        return $this->imageUrl;
    }

    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription($description): Image
    {
        $this->description = $description;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(User $user): Image
    {
        $this->user = $user;

        return $this;
    }

    public function getGroup(): ?Group
    {
        return $this->group;
    }

    public function setGroup(Group $group): Image
    {
        $this->group = $group;

        return $this;
    }

    public function getUploadedAt(): ?string
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt(?string $uploadedAt): Image
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }
    #endregion
}
