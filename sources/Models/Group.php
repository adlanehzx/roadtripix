<?php

namespace App\Models;

use App\Core\QueryBuilder;
use App\Services\Factory\UserFactory;
use PDO;

class Group extends Model
{
    private ?int $id = null;
    private $name;

    /**
     * @var User[] 
     */
    private array $users = [];

    private array $usersPermissions = []; // user->id => permissions

    private $createdAt;


    public function addOwner(User $user): void
    {
        $this->addUserWithPermission($user, GroupPermission::ownerPermission());
    }

    public function addMember(User $user): void
    {
        $this->addUserWithPermission($user, GroupPermission::memberPermission());
    }

    // TODO: change to add to db directly.
    // TODO: we check directly wether the user exist in the db, without caring about in-memory users/perms.
    // TODO: add the method getUserPermissions

    private function addUserWithPermission(User $user, GroupPermission $permission): void
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
        // TODO: make it return real Images.
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

    public function delete()
    {
        $qb = new QueryBuilder();

        $qb
            ->delete('groups')
            ->where('id', $this->id)
            ->execute();
    }

    protected function persist(): void
    {
        if ($this->id === null) {
            $this->freshPersist();
            return;
        }
    }

    private function freshPersist()
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

    private function persistUsers()
    {
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

    // TODO: tweak -> query the db directly.
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

    public function getOwner(): User
    {
        $qb = new QueryBuilder();
        $result = $qb
            ->select([
                'users.id',
                'users.username',
                'users.first_name',
                'users.last_name',
                'users.password',
                'users.email',
                'users.country',
                'users.created_at',
            ])
            ->from('groups g')
            ->join('user_groups', 'g.id', 'user_groups.group_id')
            ->join('users', 'users.id', 'user_groups.user_id')
            ->join('user_group_permissions ugp', 'ugp.group_id', 'g.id')
            ->where('ugp.permission_id', GroupPermission::OWNER_PERMISSION_ID)
            ->where('g.id', $this->id)
            ->fetch();

        if (empty($result)) {
            return null;
        }

        $owner = UserFactory::createFromDatabase($result);

        return $owner;
    }

    #endregion
}
