<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class JobVacancy extends Model
{
    protected $fillable = [
        'personal_company_id',
        'job_position',
        'slug_job_position',
        'job_description',
        'job_city',
        'job_address',
        'job_salary_first',
        'job_salary_last',
        'job_deadline',
        'job_status'
    ];

    // relasi job vacancy ke personal company (many to one)
    public function personalCompany()
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

    // ambil semua data job vacancy berdasarkan id personal company
    public static function getAllJobVacancy()
    {
        $user = Auth::user();

        return JobVacancy::where('personal_company_id', $user->personalCompany->id)->orderByDesc('id')->get();
    }
}
