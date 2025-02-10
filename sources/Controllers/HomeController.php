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
        return $this->render('home/index');
    }

    public function dashboard()
    {
        if (Authenticator::check()) {
            $this->redirect('login/index');
        }

        return $this->render('home/dashboard');
    }
}
