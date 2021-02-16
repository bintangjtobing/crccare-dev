<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ecologicalimpact extends Model
{
    protected $table = 'ecologicalimpacts';
    protected $fillable = [
        'userid', 'f9', 'f10', 'f11', 'f12', 'f13',
    ];
}
