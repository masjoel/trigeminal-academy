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
            $table->timestamp('deleted_at')->nullable();
            $table->boolean('is_synced')->default(false);
            $table->boolean('is_deleted')->default(false);
            $table->boolean('delete_synced')->default(false);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('adpdd_induks', function (Blueprint $table) {
            $table->dropColumn('deleted_at');
            $table->dropColumn('is_synced');
            $table->dropColumn('is_deleted');
            $table->dropColumn('delete_synced');
        });
    }
};
