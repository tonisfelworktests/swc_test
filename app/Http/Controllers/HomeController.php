<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function profile(int $id = null) {
        return view('profile', [
           "user" => !$id ? Auth::user() : User::findOrFail($id),
           "config" => [ "format" => "DD.MM.YYYY" ]
        ]);
    }
}
