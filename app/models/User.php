<?php

namespace App\Models;

use App\Core\App;
use Exception;

class User extends Record
{
    protected static $table = 'users';

    protected static $recordable = ['name'];

    public $id;
}

?>