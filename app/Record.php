<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
    //
    protected $fillable = [
        'user_id',
        'participant_id',
        'event_name',
        'student_id',
        'code'
    ];
    // protected $casts = [
    //     'email_verified_at' => 'datetime',
    //     'created_at'  => 'date:M d, Y',
    //     'updated_at' => 'datetime:Y-m-d',
    //     'upda' => 'datetime:Y-m-d'
    // ];

    public function participated()
    {
        return $this->belongsTo(Participant::class, 'participant_id');
    }

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public function student()
    {
        return $this->belongsTo(Participant::class, 'student_record_id', 'student_id');
    }
}
