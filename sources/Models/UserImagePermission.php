<?php

namespace App\Models;

use App\Core\QueryBuilder;

class UserImagePermission extends Model
{
    private $userId;
    private $imageId;
    private $permissionId;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'user_image_permissions';
    }

    protected function persist()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder
            ->insert($this->tableName, [
                'user_id' => $this->userId,
                'image_id' => $this->imageId,
                'permission_id' => $this->permissionId
            ])
            ->execute();
    }

    // Getters and setters
    public function getUserId()
    {
        return $this->userId;
    }

    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    public function getImageId()
    {
        return $this->imageId;
    }

    public function setImageId($imageId)
    {
        $this->imageId = $imageId;

        return $this;
    }

    public function getPermissionId()
    {
        return $this->permissionId;
    }

    public function setPermissionId($permissionId)
    {
        $this->permissionId = $permissionId;

        return $this;
    }
}