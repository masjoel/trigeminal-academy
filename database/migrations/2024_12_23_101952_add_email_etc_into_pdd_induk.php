<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('adpdd_induks', function (Blueprint $table) {
            $table->string('email')->after('kcds')->nullable();
            $table->string('wakil_dpp')->after('email')->nullable();
            $table->string('wakil_dpw')->after('wakil_dpp')->nullable();
            $table->string('wakil_dpd')->after('wakil_dpw')->nullable();
            $table->string('wakil_dpc')->after('wakil_dpd')->nullable();
            $table->string('wakil_dpac')->after('wakil_dpc')->nullable();
            $table->string('image_ktp')->after('wakil_dpac')->nullable();
            $table->string('status')->after('image_ktp')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adpdd_induks', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->dropColumn('wakil_dpp');
            $table->dropColumn('wakil_dpw');
            $table->dropColumn('wakil_dpd');
            $table->dropColumn('wakil_dpc');
            $table->dropColumn('wakil_dpac');
            $table->dropColumn('image_ktp');
            $table->dropColumn('status');
        });
    }
};
