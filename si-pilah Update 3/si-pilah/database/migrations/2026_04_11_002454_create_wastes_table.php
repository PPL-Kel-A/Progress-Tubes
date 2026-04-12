<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('wastes', function (Blueprint $table) {
            $table->id();
            // Relasi ke tabel users
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            
            $table->decimal('weight', 8, 2); 
            $table->enum('status', ['antre', 'diproses', 'selesai'])->default('antre');
            $table->decimal('energy_generated', 8, 2)->nullable(); 
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wastes');
    }
};
