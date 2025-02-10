<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

class Image extends Model
{
    private $id;
    private $imageUrl;
    private $description;
    private User $user;
    private Group $group;
    private $uploadedAt;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'images';
    }

    protected function persist()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder
            ->insert($this->tableName, [
                'image_url' => $this->imageUrl,
                'description' => $this->description,
                'user_id' => $this->user->getId(),
                'group_id' => $this->group->getId(),
                'uploaded_at' => $this->uploadedAt
            ])
            ->execute();
    }

    #region Getters / Setters
    public function getId()
    {
        return $this->id;
    }

    public function getImageUrl()
    {
        return $this->imageUrl;
    }

    public function setImageUrl($imageUrl)
    {
        $this->imageUrl = $imageUrl;

        return $this;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function setUser(User $user): Image
    {
        $this->user = $user;

        return $this;
    }

    public function getGroup()
    {
        return $this->group;
    }

    public function setGroup(Group $group): Image
    {
        $this->group = $group;

        return $this;
    }

    public function getUploadedAt()
    {
        return $this->uploadedAt;
    }

    public function setUploadedAt($uploadedAt)
    {
        $this->uploadedAt = $uploadedAt;

        return $this;
    }
    #endregion
}
