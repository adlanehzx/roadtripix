<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

class GroupPermission extends Model
{

    public const OWNER_PERMISSION_NAME = 'owner';
    public const MEMBER_PERMISSION_NAME = 'member';
    public const MEMBER_RO_PERMISSION_NAME = 'member_ro';

    public const OWNER_PERMISSION_ID = 1;
    public const MEMBER_PERMISSION_ID = 2;
    public const MEMBER_RO_PERMISSION_ID = 3;


    private $id;
    private $permissionName;
    private $createdAt;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'group_permissions';
    }

    public function isSame(GroupPermission $permission): bool
    {
        return $this->getId() === $permission->getId();
    }

    protected function persist(): void
    {
        $queryBuilder = new QueryBuilder();
        $queryBuilder
            ->insert($this->tableName, [
                'name' => $this->permissionName,
                'created_at' => $this->createdAt
            ])
            ->execute();
    }

    public static function ownerPermission(): GroupPermission
    {
        return self::findByName(self::OWNER_PERMISSION_NAME);
    }

    public static function memberPermission(): GroupPermission
    {
        return self::findByName(self::MEMBER_PERMISSION_NAME);
    }

    public static function memberReadOnlyPermission(): GroupPermission
    {
        return self::findByName(self::MEMBER_RO_PERMISSION_NAME);
    }

    public static function findByName(string $name): ?GroupPermission
    {
        $queryBuilder = new QueryBuilder();
        $result = $queryBuilder
            ->select(['*'])
            ->from('group_permissions')
            ->where('name', $name)
            ->fetch();

        if (!$result) {
            return null;
        }

        return (new self())
            ->setId($result['id'])
            ->setPermissionName($result['name'])
            ->setCreatedAt($result['created_at'])
        ;
    }

    // Getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;

        return $this;
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
