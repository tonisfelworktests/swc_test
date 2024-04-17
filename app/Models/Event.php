<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Event extends Model
{
    use HasFactory;

    protected $fillable = [
        "title",
        "text"
    ];

    protected $relations = [
        User::class,
    ];

    protected function createdAt(): Attribute {
        return Attribute::make(
            get: fn($value) => $value ? Carbon::createFromTimeString($value)->format("d.m.Y") : Carbon::now()->format('d.m.Y')
        );
    }

    public function participants() {
        return $this->belongsToMany(User::class, 'event_participants', 'event_id', 'user_id');
    }

    public function isInParticipants() {
        return $this->participants->where('id', Auth::user()->id)->isEmpty();
    }
}
