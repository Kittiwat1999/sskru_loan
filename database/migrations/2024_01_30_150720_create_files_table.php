<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Borrower;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //['borrower_id','store_path','display_path','term','year','original_filename'];
        Schema::create('files', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->integer('borrower_id')->foreignIdFor(Borrower::class);
            $table->string('store_path');
            $table->string('display_path');
            $table->string('term');
            $table->string('year');
            $table->string('original_filename');
            $table->string('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('files');
    }
};
