<?php

namespace App\Requests;

class GroupRequest extends Request
{
    public $name;

    public function __construct()
    {
        parent::__construct();
        $this->name = $this->data['name'];
    }

    public function validate(): bool
    {
        return !empty($this->name);
    }
}
