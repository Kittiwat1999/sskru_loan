<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Address;
use App\Models\Users;
use App\Models\Parents;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowers', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Users::class);
            $table->string('prefix');
            $table->dateTime('birthday');
            $table->string('citizen_id');
            $table->string('student_id');
            $table->string('faculty');
            $table->string('major');
            $table->string('gpa');
            $table->foreignIdFor(Address::class);
            $table->string('borrower_appearance');
            $table->string('borrower_properties');
            $table->json('mariatal_status');
            $table->foreignIdFor(Parents::class);
            $table->string('phone');
            $table->string('email');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrowers');
    }
};
