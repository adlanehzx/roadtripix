<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\RegisterRequest;
use App\Services\Factory\UserFactory;
use App\Services\Validator\UserValidator;

class RegisterController extends Controller
{

  private ?UserValidator $userValidator = null;

  public function __construct()
  {
    $this->userValidator = new UserValidator();
  }

  public function index()
  {
    return $this->render('register/index');
  }

  public function post()
  {
    $request = new RegisterRequest();

    if (!$request->validate()) {
      return $this->render('register/index', ['errors' => 'Y a eu une erreur avec les données']);
    }

    $user = User::findOneByEmail($request->email);
    if ($user) {
      return $this->render('register/index', ['errors' => 'Cet email est déjà utilisé']);
    }

    $validated = $this->userValidator->validateRegister($request);

    if (!empty($validated)) {
      return $this->render('register/index', ['errors' => $validated, 'request' => $request]);
    }

    $user = UserFactory::createFromRequest($request);

    $user->save();

    return $this->redirect('/login');
  }
}
