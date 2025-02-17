<?php

namespace App\Models;

use App\Core\QueryBuilder;
use App\Services\Factory\UserFactory;
use PDO;

class Group extends Model
{
    private ?int $id = null;
    private $name;
    private $createdAt;


    public function addOwner(User $user): void
    {
        $this->addUserWithPermission($user, GroupPermission::ownerPermission());
    }

    public function addMember(User $user): void
    {
        $this->addUserWithPermission($user, GroupPermission::memberPermission());
    }

    private function addUserWithPermission(User $user, GroupPermission $permission): void
    {
        if ($this->userHasPermission($user, $permission)) {
            return;
        }

        $qb = new QueryBuilder();
        $qb->insert('user_group_permissions', [
            'user_id' => $user->getId(),
            'group_id' => $this->getId(),
            'permission_id' => $permission->getId(),
        ])
            ->execute();
    }

    /**
     * @return User[]
     */
    public function getGroupUsers(): array
    {
        $qb = new QueryBuilder();
        $result = $qb->select([
            'u.id',
            'u.username',
            'u.first_name',
            'u.last_name',
            'u.password',
            'u.email',
            'u.country',
            'u.created_at'
        ])
            ->from('groups g')
            ->join('user_group_permissions ugp', 'ugp.group_id', 'g.id')
            ->join('users u', 'ugp.user_id', 'u.id')
            ->where('g.id', $this->getId())
            ->fetchAll();
        $users = [];

        foreach ($result as $data) {
            $users[] = UserFactory::createFromDatabase($data);
        }

        return $users;
    }

    public function getGroupImages(): array
    {
        $qb = new QueryBuilder();
        $result = $qb
            ->select([
                'i.id',
                'i.image_file_name',
                'i.description',
                'i.user_id',
                'i.group_id',
                'i.uploaded_at'
            ])
            ->from('images i')
            ->join('groups g', 'i.group_id', 'g.id')
            ->where('g.id', $this->getId())
            ->fetchAll();

        if (empty($result)) {
            return [];
        }

        $images = [];
        foreach ($result as $data) {
            $images[] = (new Image())
                ->setId($data['id'])
                ->setImageFileName($data['image_file_name'])
                ->setDescription($data['description'])
                ->setUser(User::find($data['user_id']))
                ->setGroup($this)
                ->setUploadedAt($data['uploaded_at']);
        }

        return $images;
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

        $this->updatePersist();
    }

    private function freshPersist(): bool
    {
        $qb = new QueryBuilder();

        $insertedGroupId = $qb
            ->insert('groups', [
                'name' => $this->name,
                'created_at' => $this->createdAt
            ])
            ->execute();

        $this->setId($insertedGroupId);
        return true;
    }

    private function updatePersist(): bool
    {
        $qb = new QueryBuilder();

        $qb
            ->update('groups', [
                'name' => $this->name,
                'created_at' => $this->createdAt
            ])
            ->where('id', $this->getId())
            ->execute();
        return true;
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
    /**
     * @return null|GroupPermissions[]
     */
    public function getUserPermissions(User $user): ?array
    {
        $qb = new QueryBuilder();

        $result = $qb
            ->select([
                'gp.id AS permissionId',
                'gp.name AS permissionName',
                'gp.created_at AS createdAt',
            ])
            ->from('groups g')
            ->join('user_group_permissions ugp', 'g.id', 'ugp.group_id')
            ->join('users u', 'u.id', 'ugp.user_id')
            ->join('group_permissions gp', 'gp.id', 'ugp.permission_id')
            ->where('g.id', $this->getId())
            ->where('u.id', $user->getId())
            ->fetchAll();

        if (empty($result)) {
            return null;
        }

        $permissions = [];
        foreach ($result as $data) {
            $permissions[] = (new GroupPermission())
                ->setId($data['permissionId'])
                ->setPermissionName($data['permissionName'])
                ->setCreatedAt((new \DateTime($data['createdAt']))->format('Y-m-d H:i:s'));
        }

        return $permissions;
    }

    public function userHasPermission(User $user, GroupPermission $permission): bool
    {
        $userPermissions = $this->getUserPermissions($user);

        if (empty($userPermissions)) {
            return false;
        }

        foreach ($userPermissions as $userPermission) {
            if ($userPermission->isSame($permission)) {
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
                'u.id',
                'u.username',
                'u.first_name',
                'u.last_name',
                'u.password',
                'u.email',
                'u.country',
                'u.created_at',
            ])
            ->from('users u')
            ->join('user_group_permissions ugp', 'ugp.user_id', 'u.id')
            ->join('groups g', 'g.id', 'ugp.group_id')
            ->where('ugp.permission_id', GroupPermission::OWNER_PERMISSION_ID)
            ->where('g.id', $this->getId())
            ->fetch();

        if (empty($result)) {
            return null;
        }

        $owner = UserFactory::createFromDatabase($result);

        return $owner;
    }

    #endregion
}
