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
        Schema::create('policy_acceptances', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained()
                ->cascadeOnDelete();

            $table->foreignId('policy_id')
                ->constrained()
                ->cascadeOnDelete();

            // Snapshot
            $table->string('policy_type', 20);
            $table->string('policy_version', 20);

            $table->timestamp('accepted_at');

            $table->string('ip_address', 45)->nullable();

            $table->text('user_agent')->nullable();

            $table->timestamps();

            $table->index('policy_type');
            $table->index('policy_version');

            $table->unique([
                'user_id',
                'policy_id',
                'policy_version',
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('policy_acceptances');
    }
};
