<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Borrower;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('useful_activities', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_id')->foreignIdFor(Borrower::class);
            $table->string('year');
            $table->string('project_name');
            $table->string('project_location');
            $table->date('date');
            $table->string('time');
            $table->string('hour_count');
            $table->string('description');
            $table->string('store_path');
            $table->string('display_path');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('useful_activities');
    }
};
