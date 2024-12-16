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
        Schema::create('node_relations', function (Blueprint $table) {
            $table->uuid('node_id');
            $table->uuid('parent_node_id');
            $table->unsignedInteger('depth');
            $table->primary(['node_id', 'parent_node_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('node_relations');
    }
};
