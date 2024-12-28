<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Connection extends Model
{
    public $fillable = [
        'name',
        'db_host',
        'db_user',
        'db_password',
        'db_name',
        'db_port',
        'crontime',
    ];
}
