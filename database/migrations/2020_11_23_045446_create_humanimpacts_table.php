<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHumanimpactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('humanimpacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('chemicalDataId')->index('chemicalDataId')->default('0');
            $table->bigInteger('userid')->index('userid');
            $table->float('WoHR');
            $table->float('AoS');
            $table->float('GEP');
            $table->float('HGC');
            $table->float('SWEP');
            $table->float('HSWC')->nullable();
            $table->float('HGCo')->nullable();
            $table->float('HSWCo')->nullable();
            $table->float('wTGHQ')->nullable();
            $table->float('wTGHQo')->nullable();
            $table->float('wTGHQS')->nullable();
            $table->float('wTGHQSo')->nullable();
            $table->float('f5tghqc');
            $table->float('f5tghqa');
            $table->float('f6tghqc');
            $table->float('f6tghqa');
            $table->float('f7tghqc');
            $table->float('f7tghqa');
            $table->float('f8tghqc');
            $table->float('f8tghqa');
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
        Schema::dropIfExists('humanimpacts');
    }
}
