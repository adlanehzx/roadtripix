<?php

namespace App\Core;

use PDO;

class QueryBuilder
{
  private string $sql;
  private array $parameters;

  public function __construct()
  {
    $this->sql = "";
    $this->parameters = [];
  }

  public function select(array $columns)
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
    $this->sql .= " WHERE " . $columnName . " = ?";
    $this->parameters[] = $value;
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

  private function getConnection(): PDO
  {
    return new PDO("mysql:host=mariadb;dbname=database", "user", "password");
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

  public function execute()
  {
    $databaseConnection = $this->getConnection();
    $statement = $databaseConnection->prepare($this->sql);
    return $statement->execute($this->parameters);
  }
}
