<?php

use App\Models\RegisterDocument;
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
        Schema::create('borrower_register_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->forignIdFor(Users::class);
            $table->integer('register_document_id')->forignIdFor(RegisterDocument::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrower_register_documents');
    }
};
