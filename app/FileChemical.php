<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FileChemical extends Model
{
    protected $table = 'file_chemicals';
    protected $fillable = ['chemicalId', 'fileId', 'CiS', 'CiG', 'CiSW'];
    protected $with = [
        'chemical',
    ];
    public function chemical()
    {
        return $this->belongsTo(Chemical::class, 'chemicalId');
    }
}
