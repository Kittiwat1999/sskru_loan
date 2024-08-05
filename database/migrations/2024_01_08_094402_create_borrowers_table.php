<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Address;
use App\Models\Users;
use App\Models\BorrowerApprearanceType;
use App\Models\Faculties;
use App\Models\Majors;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('borrowers', function (Blueprint $table) {

            $table->id();
            $table->integer('user_id')->foreignIdFor(Users::class);
            $table->integer('address_id')->foreignIdFor(Address::class);
            $table->integer('borrower_appearance_id')->foreignIdFor(BorrowerApprearanceType::class);
            $table->date('birthday');
            $table->string('citizen_id');
            $table->string('student_id');
            $table->integer('faculty_id')->foreignIdFor(Faculties::class);
            $table->integer('major_id')->foreignIdFor(Majors::class);
            $table->integer('grade');
            $table->string('gpa');
            $table->json('marital_status');
            $table->string('phone');
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
