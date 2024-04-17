<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Support\Facades\Auth;

class APIParticipantController extends Controller
{
    public function watch(int $id) {
        $event = Event::with('participants')->findOrFail($id);
        return response()->json([
            "error" => null,
            "result" => $event->participants
                                ]);
    }

    public function store(int $id) {
        $userID = Auth::user()->id;

        if (EventParticipant::where('user_id', $userID)
                ->where("event_id", $id)
                ->get()
                ->isEmpty()) {
            $eventParticipant           = new EventParticipant();
            $eventParticipant->user_id  = $userID;
            $eventParticipant->event_id = $id;
            $eventParticipant->save();
        }

        return response()->json([
            "error" => null,
            "result" => Event::with('participants')->findOrFail($id)->participants
                                ]);
    }

    public function delete(int $id) {
        EventParticipant::where("event_id", $id)
            ->where("user_id", Auth::user()->id)
            ->delete();

        return response()->json([
            "error" => null,
            "result" => Event::with('participants')->findOrFail($id)->participants
                                ]);
    }
}
