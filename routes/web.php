<?php

use App\Http\Controllers\TodoController;
use App\Models\Todo;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/login', function () {
    return view('auth.login');
})->name("login");


Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

    Route::post("todo/task/update/status", [TodoController::class, 'changeStatus']);
    Route::post("todo/task/destroy", [TodoController::class, 'destroy']);
    Route::post("todo/task/create", [TodoController::class, 'store']);
    Route::post("todo/task/update", [TodoController::class, 'update']);
});



Route::get("/makeTodo", function(){

    for ($i=0; $i < 100; $i++)
    {
        $t = Todo::create([
            "name" => Str::random(10),
            "status" => random_int(0, 1),
            "visibility" => random_int(1,3),
            "user_id" => random_int(1,10)
        ]);


        if ( $t->visibility == 3 )
        {
            User::find(random_int(1,10))->accessibleTodos()->attach($t);
        }

    }
    dd($t);
});


//
