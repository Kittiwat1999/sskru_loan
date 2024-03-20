<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Borrower;
use App\Models\Nessessities;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrower_nessessities', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_id')->foreignIdFor(Borrower::class);
            $table->integer('nessessity_id')->foreignIdFor(Nessessities::class)->nullable();
            $table->string('other');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrower_nessessities');
    }
};
