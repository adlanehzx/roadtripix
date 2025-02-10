<?php

namespace App\Requests;

class LoginRequest extends Request
{
  public string $email;
  public string $password;

  public function __construct()
  {
    parent::__construct();
    $this->email = $this->data['email'];
    $this->password = $this->data['password'];
  }

  public function validate(): bool
  {
    return filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false && !empty($this->password);
  }
}
