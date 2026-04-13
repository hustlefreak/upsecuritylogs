<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Visitor extends Model
{
    protected $fillable = ['firstName', 'lastName', 'id_number', 'phone', 'company', 'reason_for_visit'];

    public function attendances()
    {
        return $this->hasMany(VisitorAttendance::class);
    }
}
