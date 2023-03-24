<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->text('document_type');
            $table->text('cust_dob');
            $table->text('cust_id_number');
            $table->text('doc_front');
            $table->text('doc_back');
            $table->text('live_photo');
            $table->text('status');
            $table->longText('id_data');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('files', function (Blueprint $table) {
            $table->dropColumn('document_type');
            $table->dropColumn('cust_dob');
            $table->dropColumn('cust_id_number');
            $table->dropColumn('doc_front');
            $table->dropColumn('doc_back');
            $table->dropColumn('live_photo');
            $table->dropColumn('status');
            $table->dropColumn('id_data');
        });
    }
};
