<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Users;
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
            $table->foreignIdFor(Users::class);
            $table->string('borrower_relational');
            $table->string('nationality');
            $table->string('prefix');
            $table->string('fname');
            $table->string('lname');
            $table->dateTime('birthday');
            $table->string('phone');
            $table->string('occupation');
            $table->string('income');
            $table->boolean('alive');
            $table->foreignIdFor(Address::class);
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

            