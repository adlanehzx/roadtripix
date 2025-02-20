<?php

namespace App\Services;

use Resend;

class ResendService
{
    private $client;

    public function __construct()
    {
        $this->client = new Resend("re_3FUqCCDy_A7Tewqsoykv99HaMmXHvHR2m");
    }

    public function sendEmail($to, $subject, $body)
    {
        try {
            $response = $this->client->send([
                'from' => 'contact@roadtripix.me',
                'to' => $to,
                'subject' => $subject,
                'html' => $body,
            ]);
            
            return $response;
        } catch (ResendException $e) {
            echo 'Erreur lors de l\'envoi de l\'email: ' . $e->getMessage();
            return false;
        }
    }
}