<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class EventController extends Controller
{
    public function index() {
        return view('home', [
            "events" => Event::all(),
        ]);
    }

    public function watch(int $id) {
        $event = Event::with(['participants'])->findOrFail($id);
        return view('event', [
            "event"        => $event,
        ]);
    }

    public function join(int $event_id) {
        $participant = new EventParticipant();
        $participant->user_id = Auth::user()->id;
        $participant->event_id = $event_id;
        $participant->save();

        return redirect()->back();
    }

    public function leave(int $event_id) {
        EventParticipant::where("event_id", $event_id)
            ->where("user_id", Auth::user()->id)
            ->delete();

        return redirect()->back();
    }
}
