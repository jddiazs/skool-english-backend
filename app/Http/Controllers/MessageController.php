<?php

namespace App\Http\Controllers;

use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Course;
use App\User;

class MessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $messages = Message::where('to_user_id', '=', $user->id)->get();
        $messages = $messages->load('fromUser');

        try {
            return response()->json($messages->toArray(), 201);
        } catch (ModelNotFoundException $e) {
            return response()->json($e->getMessage(), 500);
        }

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $slide_id = $request->input('slide_id');
        $course = Course::where('id', $request->input('course_id'))->with('user')->first();
        $course = $course->load('user');
        $to_user_id = (is_null($request->input('to_user_id', null))) ? $course->user->id : $request->input('to_user_id');   
      
        try {
            $data = [
                'slide_id' => $slide_id,
                'unit_id' => $request->input('unit_id', null),
                'course_id' => $request->input('course_id', null),
                'from_user_id' => $user->id,
                'to_user_id' => $to_user_id,
                'messages'  => $request->input('messages', null),
                'parent_id' => $request->input('parent_id', null),
                'status' => 'Sin leer',
                'from_user_name' => $user->name,
                'to_user_name' => $course->user->name,
        ];
        $message = Message::create($data);
        $message = $message->load('fromUser');
        return response()->json($message, 201);
      } catch (\Exception $e) {
          return response()->json($e->getMessage(), 500);
      }
      
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function show(Message $message)
    {
        $user = Auth::user();
        if ($user->id !==  $message->to_user_id) {
            return response()->json(['messages' => 'Mensaje no existe'], 500);
        }

        $message->load('children');
        $message->load('fromUser');
        return response()->json($message, 201);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Message $message)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Message  $message
     * @return \Illuminate\Http\Response
     */
    public function destroy(Message $message)
    {
        //
    }
}
