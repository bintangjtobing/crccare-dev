<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class filename extends Model
{
    protected $table = 'filenames';
    protected $fillable = [
        'filename',
        'userid',
        'description',
    ];
}
