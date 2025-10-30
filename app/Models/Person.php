<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    //
    protected $table = 'people';

    protected $fillable = [
        'name',
        'mother_id',
        'father_id',
        'gender',
        'photo_url',
        'birth_date',
        'death_date',
        'email',
        'phone',
        'city',
        'country',
        'notes',
    ];

    public function mother()
    {
        return $this->belongsTo(Person::class, 'mother_id');
    }

    public function father()
    {
        return $this->belongsTo(Person::class, 'father_id');
    }

    public function spouses()
    {
        return $this->belongsToMany(Person::class, 'spouses', 'person_id', 'spouse_id');
    }
}
