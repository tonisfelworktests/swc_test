<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function update(Request $request) {
        $validation = Validator::make($request->all(), [
            "login" => "required",
            "name" => "required",
            "last_name" => "required",
            "birth_at" => "date"
        ]);

        $user = Auth::user();

        if ($validation->fails()) {
            return view('profile', [
                "user" => $user,
                "config" => [ "format" => "DD.MM.YYYY"]
            ])->withErrors($validation->messages());
        }

        if ($request->password == '') {
            $request->request->remove('password');
        }
        $user->update($request->all());
        $user->save();

        return view('profile', [
            "user" => $user,
            "config" => [ "format" => "DD.MM.YYYY" ]])->with([ "message" => "Profile has been updated."]);
    }
}
