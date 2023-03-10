<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Participant extends Model
{
    //
    protected $fillable = [
        'first_name',
        'last_name',
        'address',
        'student_id',
        'age'
    ];

    protected $appends = [
        'fullname'
    ];
    public function getFullnameAttribute()
    {
        $fullname = '';
        if ($this->first_name) $fullname = ucfirst($this->first_name);
        if ($this->last_name) $fullname .= ' ' . ucfirst($this->last_name);
        return $fullname;
    }

    public function record_participant()
    {
        return $this->belongsToMany(Record::class);
    }
}
