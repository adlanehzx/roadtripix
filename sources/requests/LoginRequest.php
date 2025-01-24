<?php

class LoginRequest
{
  public string $email;
  public string $password;

  public function __construct()
  {
    $this->email = strtolower(trim(htmlspecialchars($_POST["email"])));
    $this->password = $_POST["password"];
  }
}
