<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

class Group extends Model
{
    private $id;
    private $name;
    private $createdAt;

    public function __construct()
    {
        parent::__construct();
        $this->tableName = 'groups';
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
        $queryBuilder
            ->insert($this->tableName, [
                'name' => $this->name,
                'created_at' => $this->createdAt
            ])
            ->execute();
    }

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
}