<?php

namespace App\Services;

use App\Models\GroupInvitation;
use Resend;

class ResendService
{
    private $client;

    public function __construct()
    {
        $this->client = Resend::client('re_XBCxN9Hw_9DdwQ15twuGsJUWrJQDD1uzY');
    }

    public function sendEmail($to, $subject, $body)
    {
        try {
            $response = $this->client->emails->send([
                'from' => 'contact@roadtripix.me',
                'to' => [$to],
                'subject' => $subject,
                'html' => $body,
            ]);
            return true;
        } catch (\Exception $e) {
            echo 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage();
            return false;
        }
    }

    public function sendInvite(?GroupInvitation $groupInvitation)
    {
        if (empty($groupInvitation)) {
            return;
        }

        $invitationLink = 'https://roadtripix.me/invitation/' . $groupInvitation->getToken();
        $subject = 'Invitation à rejoindre le groupe Roadtripix';
        $body = '
            <html>
            <head>
                <title>Invitation à rejoindre le groupe Roadtripix</title>
            </head>
            <body>
                <p>Bonjour,</p>
                <p>Vous avez été invité à rejoindre le groupe Roadtripix. Veuillez cliquer sur le lien ci-dessous pour accepter l\'invitation :</p>
                <p><a href="' . $invitationLink . '">Accepter l\'invitation</a></p>
                <p>Ce lien expirera dans 7 jours.</p>
                <p>Cordialement,<br>L\'équipe Roadtripix</p>
            </body>
            </html>
        ';

        $this->sendEmail($groupInvitation->getUser()->getEmail(), $subject, $body);
    }
}
