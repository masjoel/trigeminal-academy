<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('perangkat_desas', function (Blueprint $table) {
            $table->string('id_ktp')->after('nik')->nullable();
        });
        DB::table('perangkat_desas')->update(['id_ktp' => DB::raw("nik")]);

        Schema::table('perangkat_desas', function (Blueprint $table) {
            $table->string('id_ktp')->unique()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('perangkat_desas', function (Blueprint $table) {
            $table->dropColumn('id_ktp');
        });
    }
};
