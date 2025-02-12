<?php

namespace App\Requests;

class InvitationRequest
{
    public static function validateSendInvitation(): array
    {
        $errors = [];

        if (!isset($_POST['group_id']) || empty($_POST['group_id'])) {
            $errors[] = 'Group ID est manquant';
        }

        if (!isset($_POST['email']) || !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'L\'email est invalide ou manquant';
        }

        return $errors;
    }

    public static function getSendInvitationData(): array
    {
        return [
            'group_id' => $_POST['group_id'] ?? null,
            'email' => $_POST['email'] ?? null,
        ];
    }

    public static function validateAcceptInvitation(): array
    {
        $errors = [];

        if (!isset($_GET['token']) || empty($_GET['token'])) {
            $errors[] = 'Token manquant';
        }

        return $errors;
    }

    public static function getAcceptInvitationData(): array
    {
        return [
            'token' => $_GET['token'] ?? null,
        ];
    }
}
