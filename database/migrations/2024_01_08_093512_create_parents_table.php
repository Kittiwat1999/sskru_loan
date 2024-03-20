<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Borrower;
use App\Models\Address;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parents', function (Blueprint $table) {
            $table->id();
            $table->integer('borrower_id')->foreignIdFor(Borrower::class);
            $table->foreignIdFor(Address::class)->nullable();
            $table->string('borrower_relational');
            $table->string('nationality');
            $table->string('prefix');
            $table->string('firstname');
            $table->string('lastname');
            $table->date('birthday');
            $table->string('citizen_id');
            $table->string('phone');
            $table->string('occupation');
            $table->string('income');
            $table->boolean('alive');
            $table->boolean('is_main_parent')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parents');
    }
};

            