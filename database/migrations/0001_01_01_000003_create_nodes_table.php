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
        Schema::create('nodes', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('parent_id')->nullable(); // Reference to the parent node
            $table->string('solid')->nullable();
            $table->string('nodeable_type'); // Polymorphic relationship type
            $table->uuid('nodeable_id'); // Polymorphic relationship ID
            $table->timestamps();

            $table->index(['nodeable_type', 'nodeable_id']); // Polymorphic index
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('nodes');
    }
};
