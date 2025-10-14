<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('assistances', function (Blueprint $table) {
            $table->unsignedBigInteger('reported_by')->nullable()->after('student_id');
            $table->foreign('reported_by')->references('id')->on('teachers')->nullOnDelete();
        });
    }

    public function down()
    {
        Schema::table('assistances', function (Blueprint $table) {
            $table->dropForeign(['reported_by']);
            $table->dropColumn('reported_by');
        });
    }
};

