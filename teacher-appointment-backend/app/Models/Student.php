<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    protected $fillable = [
        'user_id',
        'roll_number',
        'department',
        'year',
        'section',
    ];

    public function user() {
    return $this->belongsTo(User::class);
}


public function appointments() {
    return $this->hasMany(Appointment::class);
}

}
