<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\User;
use Illuminate\Http\Request;
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
        $todos = Auth::user()->accessibleTodos;
        $todos = $todos->merge( Todo::where("visibility", 1)->get() );
        $todos = $todos->merge( Auth::user()->todos )->reverse();
        $users = User::all();

        return view('home', [
            "users" => $users,
            "todos" => $todos
        ]);
    }
}
