<?php

use App\Models\Faculties;
use App\Models\Majors;
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
        Schema::create('teacher_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->foreignIdFor(Users::class);
            $table->integer('faculty_id')->foreignIdFor(Faculties::class);
            $table->integer('major_id')->foreignIdFor(Majors::class);
            $table->boolean('isactive')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_accounts');
    }
};
