<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

class Image extends Model
{
    private $id;
    private $imageUrl;
    private $description;
    private $userId;
    private $groupId;
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
                'user_id' => $this->userId,
                'group_id' => $this->groupId,
                'uploaded_at' => $this->uploadedAt
            ])
            ->execute();
    }

    // Getters and setters
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

    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getGroupId()
    {
        return $this->groupId;
    }

    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

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
}