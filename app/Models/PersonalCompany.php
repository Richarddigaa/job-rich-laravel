<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalCompany extends Model
{
    protected $fillable = [
        'user_id',
        'avatars_company',
        'name_company',
        'slug_company',
        'email_company',
        'phone_company',
        'city_company',
        'address_company',
        'type_of_company',
        'description_company',
        'status_personal_company'
    ];

    // relasi personal company ke user (many to one)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // relasi personal company ke job vacancy (one to many)
    public function jobVacancies()
    {
        return $this->hasMany(JobVacancy::class);
    }
}
