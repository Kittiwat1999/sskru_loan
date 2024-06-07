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
        Schema::create('addon_documents', function (Blueprint $table) {
            $table->id();
            $table->boolean('isactive')->default(true);
            $table->string('title');
            $table->boolean('for_minors')->default(false);
            $table->boolean('generate_file')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('add_on_documents');
    }
};
