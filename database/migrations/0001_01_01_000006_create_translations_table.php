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
        Schema::create('translations', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->unsignedTinyInteger('locale');
            $table->string('translatable_type');
            $table->foreignUuid('translatable_id');
            $table->string('attribute');
            $table->text('value');
            $table->timestamps();

            $table->unique(['translatable_type', 'translatable_id', 'locale', 'attribute']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translations');
    }
};
