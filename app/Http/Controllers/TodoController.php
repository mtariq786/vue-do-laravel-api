<?php

namespace App\Http\Controllers;

use App\Todo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Todo::where('user_id',Auth::id())->get();
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


        $data = $request->validate([
           'title' => 'required|string',
            'completed' => 'required|boolean'

        ]);

        $todo = Todo::create([
            'user_id' => Auth::id(),
            'title'=>$request->title,
            'completed'=>$request->completed,


        ]);

        return response($todo,201);

    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Todo $todo)
    {

        if($todo->user_id !== Auth::id()){

            return response()->json('User is unauthorized',401);
        }
        $data = $request->validate([
            'title' => 'required|string',
            'completed' => 'required|boolean'

        ]);

        $todo->update($data);

        return response($todo,200);
    }
    public function checkAll(Request $request)
    {
        $data = $request->validate([
            'completed' => 'required|boolean'
        ]);

        Todo::where('user_id',Auth::id())->update($data);

        return response('updated all',200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Todo  $todo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Todo $todo)
    {
        if($todo->user_id !== Auth::id()){

            return response()->json('User is unauthorized',401);
        }
        $todo->delete();

        return response('deleted to item',200);

    }

    public function DeleteAll(Request $request)
    {

       $request->validate([

           'todos'=>'required|array'
       ]);


       auth()->user()->todos()->where('completed', true)->delete();

//       Todo::destroy($request->todos);

       return response('deleted all',200);

    }
}
