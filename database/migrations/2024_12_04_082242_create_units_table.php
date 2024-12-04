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
        Schema::create('units', function (Blueprint $table) {
            $table->id();
            $table->enum('unit_type', ['apartment', 'villa', 'twinhouse', 'penthouse', 'townhouse', 'duplex']);
            $table->string('name');
            $table->string('area');
            $table->string('address');
            $table->integer('rooms');
            $table->integer('bathrooms');
            $table->boolean('is_finished')->default(1);
            $table->foreignId('owner_id')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};
