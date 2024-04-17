<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventParticipant;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class APIEventController extends Controller
{
    public function store(Request $request) {
        $validation = Validator::make($request->all(), [
            "title" => "required",
            "text" => "required"
        ]);

        if ($validation->fails()) {
            return response()->json([
                                        "error" => $validation->messages(),
                                        "result" => null
                                    ], 500);
        }

        $event = new Event();
        $event->title = $request->post('title');
        $event->text = $request->post('text');
        $event->creator_id = Auth::user()->id;
        $event->save();

        return response()->json([
                                    "error" => null,
                                    "result" => $event
                                ]);
    }

    public function index(): JsonResponse {
        return response()->json([
                                    "error" => null,
                                    "result" => Event::all()
                                ]);
    }

    public function update(Request $request, int $id): JsonResponse {
        $validation = Validator::make($request->all(), [
            "title" => "required",
            "text" => "required"
        ]);

        if ($validation->fails()) {
            return response()->json([
                                        "error" => $validation->messages(),
                                        "result" => null
                                    ], 500);
        }

        $event = Event::findOrFail($id);
        $event->update($request->all());

        return response()->json([
            "error" => null,
            "result" => $event
                                ]);
    }

    public function delete(int $id) {
        if (Event::find($id)->creator_id == Auth::user()->id) {
            $deleteResult = Event::find($id)->delete();
            return response()->json([
                                        "error" => null,
                                        "result" => $deleteResult
                                    ]);
        } else {
            return response()->json([
                "error" => "Forbidden",
                "result" => null
                                    ], 403);
        }
    }

    public function watch(int $id) {
        $event = Event::findOrFail($id);

        return response()->json([
            "error" => null,
            "result" => $event->with('participants')->findOrFail($id)
                                ]);
    }
}
