<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventParticipant extends Model
{
    use HasFactory;

    protected $fillable = [
        "event_id",
        "user_id"
    ];

    protected $relations = [
        User::class,
        Event::class
    ];

    public function user() {
        return $this->belongsToMany(User::class);
    }

    public function event() {
        return $this->belongsToMany(Event::class);
    }
}
