<?php

namespace App\Controllers;

use App\Core\Authenticator;

class HomeController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }
    public function index()
    {
        return $this->render('home/index', [
            'username' => $this->user->getUsername(),
            'userId' => $this->user->getId(),
            'groups' => $this->user->getUserGroupsNew()
        ]);
    }

    public function dashboard()
    {
        if (Authenticator::check()) {
            $this->redirect('login/index');
        }

        return $this->render('home/dashboard');
    }
}
