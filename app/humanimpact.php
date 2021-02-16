<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class humanimpact extends Model
{
    protected $table = 'humanimpacts';
    protected $fillable = [
        'userid', 'WoHR', 'AoS', 'GEP', 'HGC', 'HGCo', 'SWEP', 'HSWC', 'HSWCo', 'wTGHQ', 'wTGHQo', 'wTGHQS', 'wTGHQSo', 'f5tghqc', 'f6tghqc', 'f7tghqc', 'f8tghqc', 'f5tghqa', 'f6tghqa', 'f7tghqa', 'f8tghqa', 'chemicalDataId', 'summaryFileId'
    ];
}
