<?php

namespace App\Models;

use App\Core\QueryBuilder;
use PDO;

abstract class Model
{
    protected static $db;
    protected $tableName;

    public function __construct() {}

    public static function setDb(PDO $db)
    {
        self::$db = $db;
    }

    protected function getDb()
    {
        if (self::$db === null) {
            throw new \Exception("Database connection is not set.");
        }
        return self::$db;
    }

    abstract protected function persist();

    public function save()
    {
        if (empty($this->tableName)) {
            throw new \Exception("Table name is not set.");
        }
        $this->persist();
    }
}
