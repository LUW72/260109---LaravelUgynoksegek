<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Agency extends Model
{
    protected $fillable = [
        'name',
        'country',
        'type'
    ];

    public function events() 
    {
        return $this->hasMany(Event::class);
    }
}
