<?php

use App\Models\Documents;
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
        Schema::create('doc_must_be_teacher_comments', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->foreignIdFor(Documents::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_must_be_teacher_comments');
    }
};
