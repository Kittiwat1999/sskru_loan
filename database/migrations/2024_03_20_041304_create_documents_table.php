<?php

use App\Models\DocTypes;
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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->integer('doctype_id')->foreignIdFor(DocTypes::class);
            $table->integer('last_access')->foreignIdFor(Users::class);
            $table->string('year');
            $table->string('term');
            $table->boolean('need_useful_activity')->default(false);
            $table->boolean('need_teacher_comment')->default(false);
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('isactive')->default(true);
            $table->string('description')->default('-');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
