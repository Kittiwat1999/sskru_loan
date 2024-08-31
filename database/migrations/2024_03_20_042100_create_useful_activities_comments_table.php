<?php

use App\Models\BorrowerDocument;
use App\Models\Comments;
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
        Schema::create('useful_activities_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_document_id')->foreignIdFor(BorrowerDocument::class);
            $table->integer('commnet_id')->foreignIdFor(Comments::class)->nullable();
            $table->string('custom_comment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('useful_activities_comments');
    }
};
