<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bookmark extends Model
{
    protected $fillable = ['personal_applicant_id', 'job_vacancy_id'];

    // relasi personal applicant ke job vacancy (many to one)
    public function applicant()
    {
        return $this->belongsTo(PersonalApplicant::class);
    }

    // relasi job vacancy ke personal applicant (many to one)
    public function job()
    {
        return $this->belongsTo(JobVacancy::class);
    }
}
