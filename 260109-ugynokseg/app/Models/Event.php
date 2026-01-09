<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'agency_id',
        'name',
        'limit',
        'type',
        'date',
        'location',
        'status'
    ];

    protected $casts = [
        'date' => 'datetime',
        'status' => 'integer',
    ];

    public function agency() {
        return $this->belongsTo(Agency::class);
    }

    public function participates() {
        return $this->hasMany(Participate::class);
    }

    public function users() {
        return $this->belongsToMany(User::class, 'participates')
            ->withPivot(['present'])
            ->withTimestamps();
    }

    public function attendingCount(): int {
        return $this->participates()->where('present', true)->count();
    }

    public function hasFreeSpot(): bool {
        return $this->attendingCount() < $this->limit;
    }
}
