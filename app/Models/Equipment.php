<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = ['name', 'quantity', 'brand', 'model', 'serial_numbers', 'quantity', 'status'];

    public function logs()
    {
        return $this->hasMany(EquipmentLog::class);
    }
}
