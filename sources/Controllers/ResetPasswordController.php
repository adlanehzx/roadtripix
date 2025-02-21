<?php

namespace App\Controllers;
use App\Models\User;
use App\Services\ResendService;

class ResetPasswordController extends Controller
{

    public function __construct()
    {
        session_start();

    }

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
            return $this->render('login/index', ['success' => ['Un email vous a été envoyé avec les instructions pour réinitialiser votre mot de passe.']]);
        } else {
            return $this->render('login²²²²/index', ['errors' => ['Une erreur est survenue lors de l\'envoi de l\'email.']]);
        }

        
    }
    

    public function showResetForm($token, $email)
    {
        if (time() > $_SESSION['reset_token_expiration']) {
            return $this->render('reset/expired_link', ['errors' => ['Le lien a expiré.']]);
        }
    
        if ($_SESSION['reset_token'] !== $token) {
            return $this->render('reset/expired_link', ['errors' => ['Token invalide.']]);
        }
    
        return $this->render('reset/reset_form', ['email' => urldecode($email), 'token' => $token]);
    }
    
    public function resetPassword($token, $email)
    {
        if (!isset($_SESSION['reset_token_expiration']) || time() > $_SESSION['reset_token_expiration']) {
            return $this->render('reset/expired_link', ['errors' => ['Le lien a expiré.']]);
        }
        if (!isset($_SESSION['reset_token']) || $_SESSION['reset_token'] !== $token) {
            return $this->render('reset/expired_link', ['errors' => ['Token invalide.']]);
        }
        
        if (!isset($_POST['password']) || !isset($_POST['passwordConfirm'])) {
            return $this->render('reset/reset_form', [
                'errors' => ['Les deux champs de mot de passe sont requis.'],
                'email' => urldecode($email),
                'token' => $token
            ]);
        }
        
        $password = $_POST['password'];
        $passwordConfirm = $_POST['passwordConfirm'];
        
        if ($password !== $passwordConfirm) {
            return $this->render('reset/reset_form', [
                'errors' => ['Les mots de passe ne correspondent pas.'],
                'email' => urldecode($email),
                'token' => $token
            ]);
        }
        
        if (strlen($password) < 6) {
            return $this->render('reset/reset_form', [
                'errors' => ['Le mot de passe doit contenir au moins 6 caractères.'],
                'email' => urldecode($email),
                'token' => $token
            ]);
        }

        $email = urldecode($email); 
        

        
        $user = User::findOneByEmail($email);
        if (!$user) {
            return $this->render('reset/expired_link', ['errors' => ['Utilisateur non trouvé.']]);
        }
        
        $user->updatePassword($password);
        $user->save();
        
        
        unset($_SESSION['reset_token']);
        unset($_SESSION['reset_token_expiration']);
        
        return $this->render('reset/success', ['success' => ['Votre mot de passe a été réinitialisé avec succès.']]);
        return $this -> redirect('/login');
        
    
    }
    
       
    
}
?>