<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VisitorAttendance extends Model
{
    protected $fillable = ['visitor_id', 'office_id', 'staff_to_visit', 'person_to_visit_name', 'purpose', 'time_in', 'time_out', 'notes'];

    protected $casts = [
        'time_in' => 'datetime',
        'time_out' => 'datetime',
    ];

    public function visitor()
    {
        return $this->belongsTo(Visitor::class);
    }

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_to_visit');
    }
}
