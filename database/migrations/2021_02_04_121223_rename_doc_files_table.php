<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameDocFilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::rename('doc_files', 'file_documents');
        Schema::table('file_documents', function (Blueprint $table) {
            $table->renameColumn('summaryFileId', 'fileId');
        });
        DB::statement("ALTER TABLE `file_documents` MODIFY `fileId` BIGINT NULL;");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::rename('file_documents', 'doc_files');
        Schema::table('doc_files', function (Blueprint $table) {
            $table->renameColumn('fileId', 'summaryFileId');
        });
        DB::statement("ALTER TABLE `doc_files` MODIFY `summaryFileId` BIGINT NOT NULL;");
    }
}
