<?php

namespace App\Services\Factory;

use App\Models\User;
use App\Requests\RegisterRequest;

class UserFactory
{
    public static function createFromDatabase(array $data): User
    {
        $user = new User();
        $user->setId((int) $data['id']);
        $user->setUsername($data['username']);
        $user->setFirstName($data['first_name']);
        $user->setLastName($data['last_name']);
        $user->setHashedPassword($data['password']);
        $user->setEmail($data['email']);
        $user->setCountry($data['country']);
        $user->setCreatedAt((new \DateTime($data['created_at']))->format('Y-m-d H:i:s'));

        return $user;
    }

    public static function createFromRequest(RegisterRequest $request): User
    {
        $user = new User();
        $user->setUsername($request->username);
        $user->setFirstName($request->firstname);
        $user->setLastName($request->lastname);
        $user->setPassword($request->password);
        $user->setEmail($request->email);
        $user->setCountry($request->country);
        $user->setCreatedAt((new \DateTime())->format('Y-m-d H:i:s'));

        return $user;
    }
}
