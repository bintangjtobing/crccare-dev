<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateFilesTableNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("ALTER TABLE `files` MODIFY `erosionValueObservation` TINYINT NULL;");
        DB::statement("ALTER TABLE `files` MODIFY `erosionValueRUSLE` TINYINT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement("ALTER TABLE `files` MODIFY `erosionValueObservation` TINYINT NOT NULL;");
        DB::statement("ALTER TABLE `files` MODIFY `erosionValueRUSLE` TINYINT NOT NULL;");
    }
}
