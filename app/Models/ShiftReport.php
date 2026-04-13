<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShiftReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'guard_id',
        'report_date',
        'shift_start',
        'shift_end',
        'guard_name',
        'post_location',
        'weather_conditions',
        'activity_entries',
        'incident_details',
        'handover_notes',
        'tech_access_logs',
        'equipment_monitoring',
    ];

    protected $casts = [
        'report_date' => 'date',
    ];

    public function securityGuard()
    {
        return $this->belongsTo(Guard::class, 'guard_id');
    }
}
