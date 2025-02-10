<?php

namespace App\Requests;

class RegisterRequest extends Request
{
    public string $username;
    public string $email;
    public string $password;
    public string $passwordConfirm;
    public string $firstname;
    public string $lastname;
    public string $country;

    public function __construct()
    {
        parent::__construct();
        $this->username = $this->data['username'];
        $this->email = $this->data['email'];
        $this->password = $this->data['password'];
        $this->passwordConfirm = $this->data['passwordConfirm'];
        $this->firstname = $this->data['firstname'];
        $this->lastname = $this->data['lastname'];
        $this->country = $this->data['country'];
    }

    public function validate(): bool
    {
        return
            !empty($this->username)
            && (filter_var($this->email, FILTER_VALIDATE_EMAIL) !== false)
            && !empty($this->password)
            && $this->password === $this->passwordConfirm
            && !empty($this->firstname)
            && !empty($this->lastname)
            && !empty($this->country)
        ;
    }
}
