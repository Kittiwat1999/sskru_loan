<?php

use App\Models\BorrowerDocument;
use App\Models\TeacherComments;
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
        Schema::create('teacher_comment_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_document_id')->foreignIdFor(BorrowerDocument::class);
            $table->integer('teacher_comment_id')->foreignIdFor(TeacherComments::class)->nullable();
            $table->string('custom_comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_comment_documents');
    }
};
