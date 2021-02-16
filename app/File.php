<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\FileChemical;
use App\FileDocument;

class File extends Model
{
    protected $table = 'files';

    protected $fillable = [
        'userId',
        'filename',
        'description',
        'weightOnHumanRisk',
        'areaOfSoil',
        'groundWaterExposure',
        'groundWaterConsumptionChild',
        'groundWaterConsumptionAdult',
        'surfaceWaterExposure',
        'surfaceWaterConsumptionChild',
        'surfaceWaterConsumptionAdult',
        'aquaticRisk',
        'erosionType', // one of [observation, rusle]
        'erosionValueObservation',
        'erosionValueRUSLE',
        'growthRateAquatic', // 0-100
        'growthRateTerrestrial', // 0-100
        'levelOfContaminant',
        'splp',
        'groundWaterDepth',
        'offsiteImpact',
        'nearestBorehole',
        'institutionControl',
    ];

    protected $with = ['chemicals', 'documents'];

    public function chemicals()
    {
        return $this->hasMany(FileChemical::class, 'fileId');
    }

    public function documents()
    {
        return $this->hasMany(FileDocument::class, 'fileId');
    }
}
