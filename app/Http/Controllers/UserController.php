<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $type)
    {
      $user = Auth::user();
      if($user->type == '0') {
        return response()->json('Los estudiantes no pueden consultar usuarios', 401);
      }
      try {
        $users = User::where("type", '=', $type)->get();
        return response()->json($users, 200);
      } catch (\Exception $e) {
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
      if($user->type == '0') {
        return response()->json('Los estudiantes no pueden crear usuarios', 401);
      }

      try {
        $data = [
          'name' => $request->input('name'),
          'identification' => $request->input('identification'),
          'email' => $request->input('email'),
          'phone_number' => $request->input('phone_number'),
          'type' => $request->input('type'),
          'password' => bcrypt($request->input('password'))
        ];
        $user = User::create($data);
        return response()->json($user, 201);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
      $currentUser = Auth::user();
      if($currentUser->type == '0' &&  $user->id != $currentUser->id) {
        return response()->json('Los estudiantes no pueden consultar otros usuarios', 401);
      }

      try {
        return response()->json($user, 201);
      } catch (ModelNotFoundException $e) {
        return response()->json($e->getMessage(), 500);
      }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
      $currentUser = Auth::user();
      if($currentUser->type == '0' &&  $user->id != $currentUser->id) {
        return response()->json('Los estudiantes no pueden editar otros usuarios', 401);
      }
      $data = [
        'name' => $request->input('name'),
        'identification' => $request->input('identification'),
        'email' => $request->input('email'),
        'phone_number' => $request->input('phone_number'),
        'type' => $request->input('type'),
        'password' => bcrypt($request->input('password'))
      ];
      User::where('id', $user->id)->update($data);

      try {
        return response()->json($user, 201);
      } catch (ModelNotFoundException $e) {
        return response()->json($e->getMessage(), 500);
      }
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }
}