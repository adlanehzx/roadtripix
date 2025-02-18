<?php

namespace App\Core;

use PDO;

class QueryBuilder
{
    private string $sql;
    private array $parameters;
    private ?bool $where = false;

    public function __construct()
    {
        $this->reset();
    }

    private function reset()
    {
        $this->sql = "";
        $this->parameters = [];
        $this->where = false;
    }

    public function select(array $columns = ['*'])
    {
        $this->sql = "SELECT " . implode(", ", $columns);
        return $this;
    }

    public function from(string $tableName)
    {
        $this->sql .= " FROM " . $tableName;
        return $this;
    }

    public function where(string $columnName, $value)
    {
        $this->sql .= (!$this->where) ? " WHERE " : " AND ";
        $this->sql .= $columnName . " = ?";
        $this->parameters[] = $value;

        $this->where = true;

        return $this;
    }

    public function join(string $tableName, string $column1, string $column2, string $type = 'LEFT')
    {
        $this->sql .= " $type JOIN $tableName ON $column1 = $column2";
        return $this;
    }

    public function insert(string $tableName, array $data)
    {
        $columns = array_keys($data);
        $values = array_values($data);

        $columnsList = implode(", ", $columns);
        $placeholders = implode(", ", array_fill(0, count($columns), "?"));

        $this->sql = "INSERT INTO $tableName ($columnsList) VALUES ($placeholders)";
        $this->parameters = $values;

        return $this;
    }

    public function update(string $tableName, array $data)
    {
        $columns = array_keys($data);
        $values = array_values($data);

        $setClause = implode(" = ?, ", $columns) . " = ?";

        $this->sql = "UPDATE $tableName SET $setClause";
        $this->parameters = $values;

        return $this;
    }

    public function delete(string $tableName)
    {
        $this->sql = "DELETE FROM $tableName";
        return $this;
    }

    public function getSql()
    {
        return $this->sql;
    }

    private function getConnection(): PDO
    {
        return new PDO(
            "mysql:host=mysql;dbname=" . $_ENV['DATABASE_NAME'],
            $_ENV['DATABASE_USER'],
            $_ENV['DATABASE_PASSWORD'],
        );
    }

    public function fetch()
    {
        $databaseConnection = $this->getConnection();
        $statement = $databaseConnection->prepare($this->sql);
        $statement->execute($this->parameters);

        return $statement->fetch(PDO::FETCH_ASSOC);
    }

    public function fetchAll()
    {
        $databaseConnection = $this->getConnection();
        $statement = $databaseConnection->prepare($this->sql);
        $statement->execute($this->parameters);

        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    public function execute(): int
    {
        $databaseConnection = $this->getConnection();
        $statement = $databaseConnection->prepare($this->sql);
        $statement->execute($this->parameters);

        $this->reset();

        return $databaseConnection->lastInsertId();
    }
}
