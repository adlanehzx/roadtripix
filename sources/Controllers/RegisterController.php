<?php

namespace App\Controllers;

use App\Models\User;
use App\Requests\RegisterRequest;
use App\Services\Factory\UserFactory;

class RegisterController extends Controller
{

  public function __construct()
  {
  }

  public function index()
  {
    return $this->render('register/index');
  }

  public function post()
  {
    $request = new RegisterRequest();

    if (!$request->validate()) {
      return $this->render('register/index', ['errors' => ['Y a eu une erreur avec les données']]);
    }

    $user = User::findOneByEmail($request->email);
    if ($user) {
      return $this->render('register/index', ['errors' => ['Cet email est déjà utilisé']]);
    }

    $user = UserFactory::createFromRequest($request);

    $user->save();

    return $this->redirect('/login');
  }
}
