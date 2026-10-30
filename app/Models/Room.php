<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    protected $fillable = ['name', 'location', 'capacity', 'is_active'];

    public function meetings()
    {
        return $this->hasMany(Meeting::class);
    }
}
