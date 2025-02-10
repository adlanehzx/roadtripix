<?php

namespace App\Controllers;

use App\Core\Authenticator;

use App\Models\User;

class Controller
{
    protected ?User $user = null;

    public function __construct()
    {
        if (!Authenticator::check()) {
            $this->redirect('/login');
        }

        $this->user = Authenticator::user();
    }

    protected function render(string $view, array $data = []): void
    {
        extract($data);
        require_once __DIR__ . "/../views/$view.php";
    }

    protected function redirect(string $url): void
    {
        header("Location: $url");
        exit();
    }
}