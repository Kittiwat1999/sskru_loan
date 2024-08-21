<?php

use App\Models\BorrowerDocument;
use App\Models\Users;
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
        Schema::create('teacher_approve_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('teacher_uid')->foreignIdFor(Users::class);
            $table->integer('borrower_document_id')->foreignIdFor(BorrowerDocument::class);
            $table->boolean('isapprove');
            $table->string('non_approve_comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_approve_documents');
    }
};
