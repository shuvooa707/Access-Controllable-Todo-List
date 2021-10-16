<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use Illuminate\Http\Request;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $t = Todo::create([
            "name" => $request->name,
            "status" => 0,
            "visibility" => $request->visibility,
            "user_id" => auth()->user()->id
        ]);

        if ( $request->visibility == 3 )
        {
            if ( $request->customUsers )
            {
                $t->permittedUsers()->sync(explode(",", $request->customUsers));
            }
        }

        return ["msg" => "success", "task" => $t];
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function show(Todo $todo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function edit(Todo $todo)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {
        $t = Todo::find($request->taskid);
        $t->update([
            "name" => $request->name,
            "visibility" => $request->visibility
        ]);


        if ($request->visibility == 3) {
            if ($request->customUsers) {
                $t->permittedUsers()->sync(explode(",", $request->customUsers));
            }
        }

        return ["msg" => "success", "task" => $t];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        $r = Todo::find(request()->taskid)->delete();

        return ["msg" => "success"];
    }



    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */



    public function changeStatus(Request $request)
    {
        // dd($request);

        $r = Todo::find($request->taskid)->update([
            "status" => $request->status
        ]);

        if ( $r )
        {
            return ["msg" => "success"];
        } else {
            return ["msg" => "failed"];
        }

    }


}
