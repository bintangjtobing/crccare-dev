<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFileChemicalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('file_chemicals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('fileId')->default('0');
            $table->bigInteger('chemicalId')->index('chemicalId');
            $table->double('CiS', 8, 5);
            $table->double('CiG', 8, 5);
            $table->double('CiSW', 8, 5);
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
        Schema::dropIfExists('file_chemicals');
    }
}
