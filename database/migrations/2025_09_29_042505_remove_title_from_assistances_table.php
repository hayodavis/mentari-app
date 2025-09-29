<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('assistances', function (Blueprint $table) {
            $table->dropColumn('title'); // 🔥 hapus kolom title
        });
    }

    public function down()
    {
        Schema::table('assistances', function (Blueprint $table) {
            $table->string('title')->nullable(); // rollback kalau perlu
        });
    }
};
