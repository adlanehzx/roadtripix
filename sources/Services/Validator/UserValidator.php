<?php

namespace App\Services\Validator;

use App\Requests\RegisterRequest;
use App\Requests\LoginRequest;

class UserValidator
{
    public function validateRegister(?RegisterRequest $request): array
    {
        $errors = [];

        if (empty($request->username)) {
            $errors['username'][] = "Le nom d'utilisateur est requis.";
        } elseif (strlen($request->username) < 3) {
            $errors['username'][] = "Le nom d'utilisateur doit comporter au moins 3 caractères.";
        }

        if (empty($request->email)) {
            $errors['email'][] = "L'email est requis.";
        } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = "L'email n'est pas valide.";
        }

        if (empty($request->password)) {
            $errors['password'][] = "Le mot de passe est requis.";
        } elseif (strlen($request->password) < 6) {
            $errors['password'][] = "Le mot de passe doit comporter au moins 6 caractères.";
        }

        if (empty($request->passwordConfirm)) {
            $errors['passwordConfirm'][] = "La confirmation du mot de passe est requise.";
        } elseif ($request->password !== $request->passwordConfirm) {
            $errors['passwordConfirm'][] = "Les mots de passe ne correspondent pas.";
        }

        if (empty($request->firstname)) {
            $errors['firstname'][] = "Le prénom est requis.";
        }

        if (empty($request->lastname)) {
            $errors['lastname'][] = "Le nom est requis.";
        }

        if (empty($request->country)) {
            $errors['country'][] = "Le pays est requis.";
        }

        return $errors;
    }

    public function validateLogin(?LoginRequest $request): array
    {
        $errors = [];

        if (empty($request->email)) {
            $errors['email'][] = "L'email est requis.";
        } elseif (!filter_var($request->email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'][] = "L'email n'est pas valide.";
        }

        if (empty($request->password)) {
            $errors['password'][] = "Le mot de passe est requis.";
        }

        return $errors;
    }
}
