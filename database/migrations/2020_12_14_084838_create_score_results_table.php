<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateScoreResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('score_results', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('userId');
            $table->bigInteger('fileId');
            $table->double('scoreAdult', 8, 5);
            $table->double('scoreChildren', 8, 5);
            $table->double('FChildren', 8, 5);
            $table->double('FAdult', 8, 5);
            $table->double('G', 8, 5);
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
        Schema::dropIfExists('score_results');
    }
}
