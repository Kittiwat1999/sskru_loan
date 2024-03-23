<?php

use App\Models\Faculties;
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
        Schema::create('faculty_accounts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->foreignIdFor(Users::class);
            $table->integer('faculty_id')->foreignIdFor(Faculties::class);
            $table->boolean('isactive');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faculty_accounts');
    }
};
