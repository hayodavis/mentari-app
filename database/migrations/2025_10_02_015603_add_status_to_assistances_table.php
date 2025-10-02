<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('assistances', function (Blueprint $table) {
            $table->enum('status', ['pending', 'in_progress', 'done'])
                  ->default('pending')
                  ->after('follow_up'); // sesuaikan kolom "after" jika perlu
        });
    }

    public function down()
    {
        Schema::table('assistances', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
