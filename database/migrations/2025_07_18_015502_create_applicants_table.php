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
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_applicant_id')->constrained('personal_applicants')->onDelete('cascade');
            $table->foreignId('job_vacancy_id')->constrained('job_vacancies')->onDelete('cascade');
            $table->string('file_cv_applicant');
            $table->string('file_portofolio_applicant')->nullable();
            $table->enum('status_applicant', ['pending', 'reviewed', 'accepted', 'rejected']);
            $table->timestamps();

            // untuk memberikan unique agar user hanya bisa melamar satu kali di job vacancy yanng sama
            $table->unique(['personal_applicant_id', 'job_vacancy_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
