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
        Schema::create('personal_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('avatars_company');
            $table->string('name_company');
            $table->string('email_company');
            $table->string('phone_company');
            $table->string('city_company');
            $table->text('address_company');
            $table->string('type_of_company');
            $table->text('description_company');
            $table->enum('status_personal_company', ['active', 'inactive', 'pending']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('personal_companies');
    }
};
