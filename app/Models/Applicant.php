<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $fillable = [
        'personal_applicant_id',
        'job_vacancy_id',
        'file_cv_applicant',
        'file_portofolio_applicant',
        'status_applicant'
    ];

    // relasi applicant ke job vacancy (many to one)
    public function job()
    {
        return $this->belongsTo(JobVacancy::class, 'job_vacancy_id');
    }

    // relasi applicant ke personal applicant (many to one)
    public function applicant()
    {
        return $this->belongsTo(PersonalApplicant::class, 'personal_applicant_id');
    }
}
