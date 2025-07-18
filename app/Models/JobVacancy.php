<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobVacancy extends Model
{
    protected $fillable = [
        'personal_company_id',
        'job_position',
        'job_description',
        'job_city',
        'job_address',
        'job_salary_first',
        'job_salary_last',
        'job_deadline',
        'job_status'
    ];

    // relasi job vacancy ke personal company (many to one)
    public function company()
    {
        return $this->belongsTo(PersonalCompany::class, 'personal_company_id');
    }

    // relasi applicant ke job vacancy (one to many)
    public function applicants()
    {
        return $this->hasMany(Applicant::class);
    }

    // relasi job vacancy ke personal applicant (many to many)
    public function bookmarkedBy()
    {
        return $this->belongsToMany(PersonalApplicant::class, 'bookmarks')->withTimestamps();
    }
}
