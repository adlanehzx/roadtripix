<?php

namespace App\Requests;

class GroupRequest extends Request
{
    public $name;
    public ?string $_method = null;

    public function __construct()
    {
        parent::__construct();
        $this->name = $this->data['name'] ?? null;
        $this->_method = $this->data['_method'] ?? null;
    }

    public function validate(): bool
    {
        return !empty($this->name);
    }
}
