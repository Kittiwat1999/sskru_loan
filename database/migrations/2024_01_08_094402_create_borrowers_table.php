<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Address;
use App\Models\Users;
use App\Models\BorrowerApprearanceType;

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
            $table->string('faculty');
            $table->string('major');
            $table->integer('grade');
            $table->string('gpa');
            $table->json('marital_status');
            $table->string('phone_number');
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
