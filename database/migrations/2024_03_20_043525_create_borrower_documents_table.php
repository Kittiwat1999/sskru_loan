<?php

use App\Models\ChildDocuments;
use App\Models\Documents;
use App\Models\BorrowerFiles;
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
        Schema::create('borrower_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->foreignIdFor(Documents::class);
            $table->integer('child_documnet_id')->foreignIdFor(ChildDocuments::class);
            $table->integer('borrower_file_id')->foreignIdFor(BorrowerFiles::class);
            $table->integer('checker_id')->foreignIdFor(Users::class)->nullable();
            $table->integer('education_fee');
            $table->integer('living_exprenses');
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
