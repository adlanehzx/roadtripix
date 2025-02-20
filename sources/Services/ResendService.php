<?php

namespace App\Services;

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
}