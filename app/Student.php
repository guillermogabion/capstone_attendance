<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    //

    protected $fillable = [
        'student_id', 'first_name', 'last_name', 'address', 'age'
    ];
}
