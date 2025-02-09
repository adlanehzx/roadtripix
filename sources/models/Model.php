<?php

namespace App\Models;

use App\Core\SQL;

class Model
{
    protected $db;

    public function __construct()
    {
        $this->db = (new SQL())->getDatabase();
    }
}