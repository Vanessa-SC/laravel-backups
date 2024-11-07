<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Configuration extends Model
{
    protected $fillable = [
        "dir_path",
        "dump_path",
        "compressor_path",
        "file_extension",
    ];
}
