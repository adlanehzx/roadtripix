<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

class ImagePermission extends Model
{
    private $id;
    private $permissionName;
    private $createdAt;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'image_permissions';
    }

    protected function persist()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder
            ->insert($this->tableName, [
                'name' => $this->permissionName,
                'created_at' => $this->createdAt
            ])
            ->execute();
    }

    // Getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function getPermissionName()
    {
        return $this->permissionName;
    }

    public function setPermissionName($permissionName)
    {
        $this->permissionName = $permissionName;

        return $this;
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }
}