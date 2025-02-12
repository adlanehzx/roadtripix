<?php

namespace App\Models;

use App\Core\QueryBuilder;
use App\Services\Factory\UserFactory;
use ErrorException;
use PDO;

class User extends Model
{
  private ?int $id = null;
  private string $username;
  private string $firstName;
  private string $lastName;
  private string $password;
  private string $email;
  private string $country;

  private $createdAt;

  public function __construct()
  {
    parent::__construct();
    $this->tableName = 'users';
  }
  #region boolean functions
  public function isValidPassword(string $password): bool
  {
    return password_verify($password, $this->password);
  }

  public function isSame(User $user): bool
  {
    return $this->getId() === $user->getId();
  }

  public function belongsTo(Group $group): bool
  {
    return in_array($group->getId(), array_column($this->getUserGroups(), 'groupId'));
  }

  #endregion



  #region getUserGroups and getUserImages
  public function getUserGroups(): array
  {
    $qb = new QueryBuilder();
    $result = $qb
      ->select(['users.id AS userId, user_groups.group_id AS groupId'])
      ->from('users')
      ->join('user_groups', 'users.id', 'user_groups.user_id', 'INNER')
      ->where('users.id', $this->getId())
      ->fetchAll();

    return $result;
  }
  #endregion


  #region finds

  public static function find($id): ?User
  {
    $qb = new QueryBuilder();
    $result = $qb
      ->select(['*'])
      ->from('users')
      ->where('id', $id)
      ->fetch();

    return $result ? UserFactory::createFromDatabase($result) : null;
  }

  public static function findOneByEmail($email): ?User
  {
    $qb = new QueryBuilder();
    $result = $qb
      ->select(['*'])
      ->from('users')
      ->where('email', $email)
      ->fetch();

    return $result ? UserFactory::createFromDatabase($result) : null;
  }

  protected function persist()
  {
    // TODO: add the same logic in Group
    if ($this->getId() !== null) {
      throw new ErrorException('Utilisateur existe déjà en BDD');
    }


    $queryBuilder = new QueryBuilder();
    $queryBuilder
      ->insert($this->tableName, [
        'username' => $this->username,
        'first_name' => $this->firstName,
        'last_name' => $this->lastName,
        'password' => $this->password,
        'email' => $this->email,
        'country' => $this->country,
        'created_at' => $this->createdAt
      ])
      ->execute();
  }
  #endregion

  #region Getters and setters

  // Getters and setters
  public function getId(): ?int
  {
    return $this->id;
  }

  public function setId(?int $id): User
  {
    $this->id = $id;
    return $this;
  }

  public function getUsername()
  {
    return $this->username;
  }

  public function setUsername($username)
  {
    $this->username = $username;

    return $this;
  }

  public function getEmail()
  {
    return $this->email;
  }

  public function setEmail(string $email)
  {
    $this->email = $email;

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

  public function getFirstName()
  {
    return $this->firstName;
  }

  public function setFirstName(string $firstName)
  {
    $this->firstName = $firstName;

    return $this;
  }

  public function getLastName()
  {
    return $this->lastName;
  }

  public function setLastName(string $lastName)
  {
    $this->lastName = $lastName;

    return $this;
  }

  public function setCountry(string $country): User
  {
    $this->country = $country;

    return $this;
  }

  public function getCountry()
  {
    return $this->country;
  }

  public function getPassword()
  {
    return $this->password;
  }

  public function setPassword(string $password)
  {
    $this->password = password_hash($password, PASSWORD_BCRYPT);

    return $this;
  }
  public function setHashedPassword(string $hashedPassword)
  {
    $this->password = $hashedPassword;

    return $this;
  }

  #endregion

}
