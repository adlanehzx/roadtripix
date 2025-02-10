<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

class UserGroupPermission extends Model
{
    private $userId;
    private $groupId;
    private $permissionId;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'user_group_permissions';
    }

    protected function persist()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder
            ->insert($this->tableName, [
                'user_id' => $this->userId,
                'group_id' => $this->groupId,
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

    public function getGroupId()
    {
        return $this->groupId;
    }

    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;

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