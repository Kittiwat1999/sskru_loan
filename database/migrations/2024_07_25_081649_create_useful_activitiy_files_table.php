<?php

use App\Models\UsefulActivities;
use App\Models\UsefulActivity;
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
        Schema::create('useful_activity_files', function (Blueprint $table) {
            $table->id();
            $table->integer('useful_activity_id')->foreignIdFor(UsefulActivity::class);
            $table->string('description')->default('-');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('full_path');
            $table->date('upload_date')->default(now());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('useful_activitiy_files');
    }
};
