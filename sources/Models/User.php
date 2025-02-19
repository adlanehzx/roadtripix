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

  public function isSame(?User $user): bool
  {
    return $this->getId() === $user?->getId();
  }

  public function belongsTo(?Group $group): bool
  {
    if (empty($group)) {
      return false;
    }

    foreach ($this->getUserGroups() as $userGroup) {
      if ($userGroup->getId() === $group->getId()) {
        return true;
      }
    }
    return false;
  }

  public function owns(?Group $group): bool
  {
    return $this->isSame($group?->getOwner());
  }

  #endregion
  #region getUserGroups and getUserImages
  /**
   * @return Group[]
   */
  public function getUserGroups(): array
  {
    $qb = new QueryBuilder();
    $result = $qb
      ->select(['g.id', 'g.name', 'g.created_at'])
      ->from('users u')
      ->join('user_group_permissions ugp', 'u.id', 'ugp.user_id', 'INNER')
      ->join('groups g', 'g.id', 'ugp.group_id')
      ->where('u.id', (int) $this->getId())
      ->fetchAll();

    if (empty($result)) {
      return [];
    }

    $userGroups = [];

    foreach ($result as $data) {
      $userGroups[] = (new Group())
        ->setId($data['id'])
        ->setName($data['name'])
        ->setCreatedAt((new \DateTime($data['created_at']))->format('Y-m-d H:i:s'));
    }

    return $userGroups;
  }

  /**
   * @return Images[]
   */
  public function getUserImages(): array
  {
    $qb = new QueryBuilder();
    $result = $qb
      ->select([
        'i.id',
        'i.description',
        'i.user_id',
        'i.group_id',
        'i.uploaded_at',
      ])
      ->from('users u')
      ->join('images i', 'i.user_id', 'u.id')
      ->where('u.id', (int) $this->id)
      ->fetchAll();

    if (empty($result)) {
      return [];
    }

    $images = [];
    foreach ($result as $image) {
      $images[] = (new Image())
        ->setId($image['id'])
        ->setDescription($image['description'])
        ->setUser($this)
        ->setGroup(Group::find($image['group_id']))
        ->setUploadedAt($image['uploaded_at']);
    }

    return $images;
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

  protected function persist(): void
  {
    if ($this->id === null) {
      $this->freshPersist();
      return;
    }

    $this->updatePersist();
  }

  protected function freshPersist(): bool
  {
    $qb = new QueryBuilder();
    $insertedId = $qb
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

    $this->setId($insertedId);

    return true;
  }

  protected function updatePersist(): bool
  {
    $qb = new QueryBuilder();
    $qb
      ->update('users', [
        'username' => $this->username,
        'first_name' => $this->firstName,
        'last_name' => $this->lastName,
        'password' => $this->password,
        'email' => $this->email,
        'country' => $this->country,
        'created_at' => $this->createdAt
      ])
      ->where('id', $this->getId())
      ->execute();
    return true;
  }

  public function updatePassword(string $newPassword): void
  {
    $passwordHashed = password_hash($newPassword, PASSWORD_BCRYPT);
    $this->setPassword($passwordHashed);
    $this->persist();

    return;
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
