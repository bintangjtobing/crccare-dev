<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('userId');
            $table->string('filename');
            $table->string('description');
            $table->integer('weightOnHumanRisk');
            $table->tinyInteger('areaOfSoil');
            $table->tinyInteger('groundWaterExposure');
            $table->double('groundWaterConsumptionChild', 8, 5);
            $table->double('groundWaterConsumptionAdult', 8, 5);
            $table->tinyInteger('surfaceWaterExposure');
            $table->double('surfaceWaterConsumptionChild', 8, 5);
            $table->double('surfaceWaterConsumptionAdult', 8, 5);
            $table->integer('aquaticRisk');
            $table->string('erosionType'); // one of [observation, rusle]
            $table->tinyInteger('erosionValueObservation');
            $table->tinyInteger('erosionValueRUSLE');
            $table->tinyInteger('growthRateAquatic'); // 0-100
            $table->tinyInteger('growthRateTerrestrial'); // 0-100
            $table->tinyInteger('levelOfContaminant');
            $table->tinyInteger('splp');
            $table->tinyInteger('groundWaterDepth');
            $table->tinyInteger('offsiteImpact');
            $table->tinyInteger('nearestBorehole');
            $table->tinyInteger('institutionControl');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('files');
    }
}
