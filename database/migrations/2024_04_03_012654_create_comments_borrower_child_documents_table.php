<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Comments;
use App\Models\BorrowerChildDocument;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('comments_borrower_child_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('comment_id')->foreignIdFor(Comments::class)->nullable();
            $table->integer('borrower_child_ducument_id')->foreignIdFor(BorrowerChildDocument::class);
            $table->string('other_comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('comments_borrower_child_documents');
    }
};
