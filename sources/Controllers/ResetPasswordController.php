<?php

namespace App\Controllers;
use App\Models\User;
use App\Services\ResendService;

class ResetPasswordController extends Controller
{
    public function index()
    {
        return $this->render('reset/index');
    }

    public function post()
    {
        if (!isset($_POST['email'])) {
            return $this->render('reset/index', ['errors' => ['L\'email n\'a pas été fourni.']]);
        }
        $email = $_POST['email'];

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return $this->render('reset/index', ['errors' => ['Email invalide']]);
        }

        $token = bin2hex(random_bytes(16)); 
        $_SESSION['reset_token'] = $token;  
        $_SESSION['reset_token_expiration'] = time() + 3600;  

        $resetLink = "http://localhost:8000/reset-password/{$token}/{$email}";
        $subject = "Réinitialisation de votre mot de passe";
        $body = "
            <h1>Réinitialisation de votre mot de passe</h1>
            <p>Bonjour,</p>
            <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le lien ci-dessous pour le faire :</p>
            <p><a href=\"$resetLink\">Réinitialiser mon mot de passe</a></p>
        ";

        $resendService = new ResendService();
        $result = $resendService->sendEmail($email, $subject, $body);

        if ($result) {
            return $this->render('reset/index', ['success' => ['Un email vous a été envoyé avec les instructions pour réinitialiser votre mot de passe.']]);
        } else {
            return $this->render('reset/index', ['errors' => ['Une erreur est survenue lors de l\'envoi de l\'email.']]);
        }
    }

    public function showResetForm($token, $email)
    {
        if (time() > $_SESSION['reset_token_expiration']) {
            return $this->render('reset/expired_link', ['errors' => ['Le lien a expiré.']]);
        }

        return $this->render('reset/reset_form', ['email' => urldecode($email), 'token' => $token]);
    }

    public function resetPassword($token, $email)
    {

        if (time() > $_SESSION['reset_token_expiration']) {
            return $this->render('reset/expired_link', ['errors' => ['Le lien a expiré.']]);
        }

        if ($token !== $_SESSION['reset_token']) {
            return $this->render('reset/reset_form', ['errors' => ['Le lien de réinitialisation est invalide.']]);
        }

        $newPassword = $_POST['new_password'];
        if (strlen($newPassword) < 6) {
            return $this->render('reset/reset_form', ['errors' => ['Le mot de passe doit contenir au moins 6 caractères.']]);
        }

     
        $user = new User();
        $user->setEmail($email); 

        $user->updatePassword($newPassword);


        unset($_SESSION['reset_token']);
        unset($_SESSION['reset_token_expiration']);

        return $this->render('reset/success', ['success' => ['Votre mot de passe a été réinitialisé avec succès.']]);
    }
}
