<?php

use App\Models\Comments;
use App\Models\Documents;
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
        Schema::create('useful_activity_statuses', function (Blueprint $table) {
            $table->id();
            $table->integer('document_id')->foreignIdFor(Documents::class);
            $table->integer('borrower_uid')->foreignIdFor(Users::class);
            $table->string('status');
            $table->integer('checker_id')->foreignIdFor(Users::class)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('useful_activity_statuses');
    }
};
