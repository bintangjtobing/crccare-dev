<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Chemical extends Model
{
    protected $table = 'chemicals';
    protected $fillable = ['name', 'formula', 'oralR', 'oralS'];
}
