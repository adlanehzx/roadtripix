<?php

namespace App\Controllers;

use App\Models\Invitation;
use App\Models\Group;
use App\Core\Authenticator;
use Resend\Resend;
use App\Requests\InvitationRequest;

class InvitationController extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function invite(int $groupId)
    {
        $group = Group::find($groupId);

        if (!$group) {
            return $this->render('errors/404');
        }

        return $this->render('invite/invite', ['groupId' => $groupId]);
    }

    public function sendInvitation()
    {
        if ($_SERVER["REQUEST_METHOD"] === "POST") {
            $errors = InvitationRequest::validateSendInvitation();

            if (!empty($errors)) {
                return $this->render('errors/validation_error', ['errors' => $errors]);
            }

            $data = InvitationRequest::getSendInvitationData();
            $groupId = $data['group_id'];
            $email = $data['email'];
            

            $group = Group::find($groupId);

            if (!$group) {
                return $this->render('errors/404');
            }

            $invitationModel = new Invitation();
            $token = $invitationModel->createInvitation($groupId, $email);

            $link = "http://localhost:8000/join-group?token=" . $token;

            $this->sendEmail($email, $group->getName(), $link);

            return $this->redirect("/group?id=$groupId&success=1");
        }

        return $this->render('errors/404');
    }

    private function sendEmail(string $email, string $link)
    {
        $resend = Resend::client('re_3FUqCCDy_A7Tewqsoykv99HaMmXHvHR2m');

        $resend->emails->send([
            'from' => 'noreply@imagePHP.com',
            'to' => $email,
            'subject' => "Invitation à rejoindre le groupe",
            'html' => "
                <h1>Invitation à rejoindre $groupName</h1>
                <p>Bonjour,</p>
                <p>Tu as été invité à rejoindre le groupe .</p>
                <p><a href='$link' style='padding:10px 20px; background:#007bff; color:white; text-decoration:none; border-radius:5px;'>Rejoindre le groupe</a></p>
                <p>Si tu ne peux pas cliquer sur le bouton, voici le lien : <a href='$link'>$link</a></p>
                <p>À bientôt !</p>
            "
        ]);
    }

    public function acceptInvitation()
    {
        session_start();

        $errors = InvitationRequest::validateAcceptInvitation();

        if (!empty($errors)) {
            echo "Token manquant.";
            return;
        }

        if (!isset($_SESSION['user_id'])) {
            header("Location: /login?error=not_logged_in");
            exit();
        }

        $data = InvitationRequest::getAcceptInvitationData();
        $token = $data['token'];
        $userId = $_SESSION['user_id'];

        $invitationModel = new Invitation();
        $invitation = $invitationModel->getInvitationByToken($token);

        if (!$invitation) {
            echo "Invitation invalide ou expirée.";
            return;
        }

        $groupId = $invitation['group_id'];
        $qb = new QueryBuilder();
        $qb->insert('user_groups', [
            'user_id' => $userId,
            'group_id' => $groupId,
        ])->execute();

        $qb->update('invitations', ['status' => 'accepted'])
            ->where('token', $token)
            ->execute();

        header("Location: /groups/$groupId?joined=1");
        exit();
    }
}
