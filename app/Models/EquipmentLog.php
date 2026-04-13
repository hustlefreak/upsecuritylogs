<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EquipmentLog extends Model
{
    protected $fillable = ['equipment_id', 'user_name', 'action', 'quantity', 'brand', 'model', 'serial_numbers', 'equipment_name', 'quantity'];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
