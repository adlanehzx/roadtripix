<?php

// TODO: utiliser prepare au lieu de query !!!

class QueryBuilder
{
  private string $sql;

  public function __construct()
  {
    $this->sql = "";
  }

  public function select(array $columns)
  {
    $this->sql = $this->sql . "SELECT " . implode(", ", $columns);

    return $this;
  }

  public function from(string $tableName)
  {
    $this->sql = $this->sql . " FROM " . $tableName;

    return $this;
  }

  public function where(string $columnName, string $columnValue)
  {
    $this->sql = $this->sql . " WHERE " . $columnName . " = " . $columnValue;

    return $this;
  }

  public function fetch()
  {
    $databaseConnection = new PDO(
      "mysql:host=mariadb;dbname=database",
      "user",
      "password"
    );

    $query = $databaseConnection->query($this->sql);

    $result = $query->fetch(PDO::FETCH_ASSOC);

    return $result;
  }

  public function fetchAll() {}

  public function execute() {}
}

$queryBuilder = new QueryBuilder();

$email = "anairi@esgi.fr";

$queryBuilder
  ->select(["id", "password", "email"])
  ->from("users")
  ->where("email", $email)
  ->fetch();
