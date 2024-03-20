<?php

use App\Models\ChildDocuments;
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
        Schema::create('doc_structures', function (Blueprint $table) {
            $table->id();
            $table->integer('child_document_id')->foreignIdfor(ChildDocuments::class);
            $table->integer('document_id')->foreignIdfor(Documents::class);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doc_structures');
    }
};
