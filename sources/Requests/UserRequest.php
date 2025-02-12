<?php

namespace App\Requests;

class UserRequest extends Request
{
    public $ids;
    public ?string $_method = null;

    public function __construct()
    {
        parent::__construct();
        $this->ids = $this->data['ids'];
    }

    public function validate(): bool
    {
        return !empty($this->name);
    }
}
