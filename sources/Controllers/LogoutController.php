<?php

namespace App\Controllers;

use App\Core\Authenticator;

class LogoutController extends Controller
{
    public function index()
    {
        Authenticator::logout();
        $this->redirect('/login');
    }
}
