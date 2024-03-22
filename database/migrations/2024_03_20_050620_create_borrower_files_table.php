<?php

use App\Models\Borrower;
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
        Schema::create('borrower_files', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_id')->foreignIdFor(Borrower::class);
            $table->string('description');
            $table->string('original_name');
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_type');
            $table->string('full_path');
            $table->date('upload_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrower_files');
    }
};
