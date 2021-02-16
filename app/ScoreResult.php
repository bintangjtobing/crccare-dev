<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ScoreResult extends Model
{
    protected $table = 'score_results';
    protected $fillable = [
        'userId',
        'fileId',
        'scoreChildren',
        'scoreAdult',
        'FChildren',
        'FAdult',
        'G',
        'ecologicalImpactScore',
        'humanImpactAdult',
        'humanImpactChild'
    ];
    protected $with = [
        'score', 'user'
    ];

    public function score()
    {
        return $this->belongsTo(File::class, 'fileId');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
