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
        Schema::create('job_vacancies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('personal_company_id')->constrained('personal_companies')->onDelete('cascade');
            $table->string('job_position');
            $table->string('slug_job_position');
            $table->text('job_description');
            $table->string('job_city');
            $table->text('job_address');
            $table->integer('job_salary_first');
            $table->integer('job_salary_last');
            $table->date('job_deadline');
            $table->enum('job_status', ['open', 'closed']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job_vacancies');
    }
};
