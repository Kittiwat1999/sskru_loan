<?php

use App\Models\Borrower;
use App\Models\Properties;
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
        Schema::create('borrower_properties', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_id')->foreignIdFor(Borrower::class);
            $table->integer('property_id')->foreignIdFor(Properties::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrower_properties');
    }
};
