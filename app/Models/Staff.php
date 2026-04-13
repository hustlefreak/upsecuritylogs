<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Staff extends Model
{
    protected $fillable = ['firstName', 'lastName', 'staff_id_number', 'office_id', 'contact_number'];

    public function office()
    {
        return $this->belongsTo(Office::class);
    }

    public function attendances()
    {
        return $this->hasMany(StaffAttendance::class);
    }
}
