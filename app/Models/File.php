<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    // file params
    protected $fillable = [
        'name',
        'extention',
        'path',
        'user_folder',
    ];
}
