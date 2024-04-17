<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Passport\ClientRepository;

class APIUserController
{
    public function register(Request $request): JsonResponse {
        $validation = Validator::make($request->all(), [
            "login" => "required|unique:users|min:4",
            "password" => "required|min:6",
            "name" => "required",
            'email' => "required|email",
            "last_name" => "required"
        ]);

        if ($validation->fails()) {
            return response()->json([
                                        "error" => $validation->messages()
                                    ], 500);
        }

        $user = new User();
        $user->login = $request->post('login');
        $user->password = Hash::make($request->post('password'));
        $user->email = $request->post('email');
        $user->name = $request->post('name');
        $user->last_name = $request->post('last_name');
        $user->save();

        if ($user->id) {
            return response()->json([
                                        "error" => null,
                                        "result" => $user
                                    ]);
        }

        return response()->json([
            "error" => "Failed user create. Try later.",
            "result" => null
                                ], 500);
    }

    public function getToken(Request $request): JsonResponse {
        $validation = Validator::make($request->all(), [
            "email" => "required|email",
            "password" => "required"
        ]);

        if ($validation->fails()) {
            return response()->json([
                                        "error" => $validation->messages()
                                    ], 500);
        }

        if (!Auth::attempt($request->all())) {
            return response()->json([
                                        "error" => "Invalid credentials",
                                        "result" => null
                                    ], 500);
        }

        $clientRepository = new ClientRepository;

        // Создаем новое клиентское приложение
        $client = $clientRepository->createPasswordGrantClient(
            Auth::user()->id,
            Auth::user()->name,
            'swc',
            '',
        );

        return response()->json([
                                    "error" => null,
                                    "result" => [
                                        "client_id" => $client->id,
                                        "client_secret" => $client->secret
                                    ]
                                ]);
    }
}
