<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

class Group extends Model
{
    private $id;
    private $name;

    /**
     * @var User[] 
     */
    private array $users = [];

    private array $usersPermissions = []; // user->id => permissions

    private $createdAt;

    public function addUserWithPermission(User $user, GroupPermission $permission): void
    {
        if (!in_array($user, $this->users)) {
            $this->users[] = $user;
        }

        if (!isset($this->usersPermissions[$user->getId()])) {
            $this->usersPermissions[$user->getId()] = [];
        }

        $this->usersPermissions[$user->getId()][] = $permission;
    }

    public function getGroupImages(): array
    {
        $qb = new QueryBuilder();
        $result = $qb
            ->select(['images.id'])
            ->from('groups')
            ->join('images', 'groups.id', 'images.group_id')
            ->where('groups.id', $this->getId())
            ->fetchAll();

        return $result;
    }

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'groups';
    }

    #region find & db invokes
    public static function findByUserId(int $userId): array
    {
        $queryBuilder = new QueryBuilder();
        $groups = $queryBuilder
            ->select(['g.*'])
            ->from('groups g')
            ->join('user_groups ug', 'g.id', 'ug.group_id')
            ->where('ug.user_id', $userId)
            ->fetchAll();
    
        $result = [];
        foreach ($groups as $group) {
            $result[] = (new self())
                ->setId($group['id'])
                ->setName($group['name'])
                ->setCreatedAt($group['created_at']);
        }
    
        return $result;
    }
    

    public static function find($id): ?Group
    {
        $queryBuilder = new QueryBuilder();
        $group = $queryBuilder
            ->select(['*'])
            ->from('groups')
            ->where('id', $id)
            ->fetch();

        if (empty($group)) {
            return null;
        }

        return (new self())
            ->setId($group['id'])
            ->setName($group['name'])
            ->setCreatedAt($group['created_at']);
    }

    protected function persist()
    {
        $queryBuilder = new QueryBuilder();
        $insertedGroupId = $queryBuilder
            ->insert('groups', [
                'name' => $this->name,
                'created_at' => $this->createdAt
            ])
            ->execute();

        $this->setId($insertedGroupId);

        foreach ($this->users as $user) {
            $qb = new QueryBuilder();
            $qb
                ->insert('user_groups', [
                    'user_id' => $user->getId(),
                    'group_id' => $this->getId(),
                ])
                ->execute()
            ;
            foreach ($this->usersPermissions[$user->getId()] as $permission) {
                $qb2 = new QueryBuilder();
                $qb2
                    ->insert('user_group_permissions', [
                        'user_id' => $user->getId(),
                        'group_id' => $this->getId(),
                        'permission_id' => $permission->getId(),
                    ])
                    ->execute()
                ;
            }
        }
    }
    #endregion

    #region getters setters

    // Getters and setters
    public function getId()
    {
        return $this->id;
    }

    public function setId(int $id): Group
    {
        $this->id = $id;
        return $this;
    }

    public function getName()
    {
        return $this->name;
    }

    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    public function getUsers(): array
    {
        return $this->users;
    }

    public function setUsers(array $users): Group
    {
        $this->users = $users;
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
    #endregion

    #region getters non-generic
    public function getUserPermissions(User $user): array
    {
        return $this->usersPermissions[$user->getId()] ?? [];
    }

    public function userHasPermission(User $user, string $permissionName): bool
    {
        foreach ($this->getUserPermissions($user) as $permission) {
            if ($permission->getName() === $permissionName) {
                return true;
            }
        }
        return false;
    }
    #endregion
}
