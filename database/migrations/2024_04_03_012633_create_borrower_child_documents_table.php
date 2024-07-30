<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Documents;
use App\Models\ChildDocuments;
use App\Models\BorrowerFiles;
use App\Models\Users;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrower_child_documents', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->foreignIdFor(Users::class);
            $table->integer('document_id')->foreignIdFor(Documents::class);
            $table->integer('child_document_id')->foreignIdFor(ChildDocuments::class);
            $table->integer('borrower_file_id')->foreignIdFor(BorrowerFiles::class);
            $table->integer('checker_id')->foreignIdFor(Users::class)->nullable();
            $table->integer('education_fee')->default(0);
            $table->integer('living_exprenses')->default(0);
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrower_child_documents');
    }
};
