<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Borrower;
use App\Models\Documents;


return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrower_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->foreignIdFor(Documents::class);
            $table->integer('borrower_id')->foreignIdFor(Borrower::class);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrower_documents');
    }
};
