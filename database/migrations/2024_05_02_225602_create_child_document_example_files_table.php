<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ChildDocuments;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('child_document_example_files', function (Blueprint $table) {
            $table->id();
            $table->integer('child_document_id')->foreignIdFor(ChildDocuments::class);
            $table->string('description');
            $table->string('file_for');
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
        Schema::dropIfExists('child_document_example_files');
    }
};
