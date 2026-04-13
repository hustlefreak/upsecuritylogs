<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Office extends Model
{
    protected $fillable = ['name', 'location', 'contact_person'];

    public function staff()
    {
        return $this->hasMany(Staff::class);
    }
}
