<?php

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
        Schema::create('personal_applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('avatars_applicant')->nullable();
            $table->string('name_applicant');
            $table->string('slug_applicant');
            $table->string('email_applicant');
            $table->string('phone_applicant');
            $table->string('city_applicant');
            $table->enum('gender', ['male', 'female']);
            $table->date('date_of_birth_applicant');
            $table->text('sumary_applicant');
            $table->enum('status_personal_applicant', ['active', 'inactive']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_applicants');
    }
};
