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
        Schema::create('collection_points', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama TPS, e.g., "TPS Kebon Jeruk"
            $table->text('address'); // Full address
            $table->decimal('latitude', 10, 8); // Koordinat latitude
            $table->decimal('longitude', 11, 8); // Koordinat longitude
            $table->string('desa')->nullable(); // Desa/Village
            $table->string('kecamatan')->nullable(); // Kecamatan/District
            $table->string('kota')->nullable(); // Kota/City
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('collection_points');
    }
};
