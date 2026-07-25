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
        Schema::create('policies', function (Blueprint $table) {
            $table->id();

            $table->enum('type', [
                'terms',
                'privacy',
                'pdpa'
            ]);

            $table->string('title');

            $table->string('version')
                ->default('1.0.0');

            $table->longText('content_html');

            $table->enum('status', [
                'draft',
                'published',
                'archived'
            ])->default('draft');

            $table->timestamp('effective_at')
                ->nullable();

            $table->timestamp('published_at')
                ->nullable();

            $table->foreignId('created_by')
                ->constrained('users');

            $table->foreignId('updated_by')
                ->constrained('users');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
