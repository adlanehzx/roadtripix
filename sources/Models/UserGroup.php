<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

class UserGroup extends Model
{
    private $userId;
    private $groupId;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'user_groups';
    }

    protected function persist()
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder
            ->insert($this->tableName, [
                'user_id' => $this->userId,
                'group_id' => $this->groupId
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
}