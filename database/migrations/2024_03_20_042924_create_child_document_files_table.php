<?php

use App\Models\ChildDocuments;
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
        Schema::create('child_document_files', function (Blueprint $table) {
            $table->id();
            $table->integer('child_document_id')->foreignIdFor(ChildDocuments::class);
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
        Schema::dropIfExists('child_document_files');
    }
};
