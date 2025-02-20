<?php

namespace App\Requests;

class GroupInvitationRequest extends Request
{
    public ?string $guestEmail = null;

    public function __construct()
    {
        parent::__construct();
        $this->guestEmail = $this->data['guestEmail'] ?? null;
    }

    public function validate(): bool
    {
        return !empty($this->guestEmail);
    }
}
