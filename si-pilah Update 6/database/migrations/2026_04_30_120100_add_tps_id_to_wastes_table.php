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
        Schema::table('wastes', function (Blueprint $table) {
            // Add tps_id column as nullable foreign key to allow gradual migration
            $table->unsignedBigInteger('tps_id')->nullable()->after('weight');
            $table->foreign('tps_id')
                  ->references('id')
                  ->on('collection_points')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('wastes', function (Blueprint $table) {
            $table->dropForeign(['tps_id']);
            $table->dropColumn('tps_id');
        });
    }
};
