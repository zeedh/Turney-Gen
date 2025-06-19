<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('competitor', function (Blueprint $table) {
            $table->unsignedInteger('seed')->nullable()->after('confirmed'); // atau atur di posisi yang kamu mau
        });
    }

    public function down(): void
    {
        Schema::table('competitor', function (Blueprint $table) {
            $table->dropColumn('seed');
        });
    }
};

