<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalApplicant extends Model
{
    protected $fillable = [
        'user_id',
        'avatars_applicant',
        'name_applicant',
        'slug_applicant',
        'email_applicant',
        'phone_applicant',
        'city_applicant',
        'gender',
        'date_of_birth_applicant',
        'sumary_applicant',
        'status_personal_applicant'
    ];

    // relasi personal applicant ke user (many to one)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi personal applicant ke job vacancy (one to many)
    public function applications()
    {
        return $this->hasMany(Applicant::class);
    }

    // relasi personal applicant ke job vacancy (many to many)
    public function bookmarks()
    {
        return $this->belongsToMany(JobVacancy::class, 'bookmarks')->withTimestamps();
    }
}
