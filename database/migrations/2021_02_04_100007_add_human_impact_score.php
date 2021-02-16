<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddHumanImpactScore extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('score_results', function (Blueprint $table) {
            $table->double('humanImpactChild', 8, 5)->after('ecologicalImpactScore');
            $table->double('humanImpactAdult', 8, 5)->after('humanImpactChild');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('score_results', function (Blueprint $table) {
            $table->dropColumn('humanImpactChild');
            $table->dropColumn('humanImpactAdult');
        });
    }
}
