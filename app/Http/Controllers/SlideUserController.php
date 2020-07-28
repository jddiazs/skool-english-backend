<?php

namespace App\Http\Controllers;

use App\SlideUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SlideUserController extends Controller
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $user = Auth::user();
      $slide_id = $request->input('slide_id');

      $slideUser = SlideUser::getByUserAndSlide($user->id, $slide_id);

      if(empty($slideUser)) {
        try {
          $data = [
            'slide_id' => $slide_id,
            'unit_id' => $request->input('unit_id', null),
            'course_id' => $request->input('course_id', null),
            'user_id' => $user->id,
            'response_user'  => $request->input('response_user', null),
            'status' => $request->input('status')
          ];
          $slideUser = SlideUser::create($data);
          return response()->json($slideUser, 201);
        } catch (\Exception $e) {
          return response()->json($e->getMessage(), 500);
        }
      } else {
        $data = [
          'response_user'  => $request->input('response_user', null),
          'status' => $request->input('status')
        ];

        try {
          Slide::where('slide_id', '=', $slide_id)
            ->where('user_id', '=', $user->id)
            ->update($data);
          return response()->json($data, 201);
        } catch (\Exception $e) {
          return response()->json($e->getMessage(), 500);
        }
      }
    }



    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\SlideUser  $slideUser
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, SlideUser $slideUser)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\SlideUser  $slideUser
     * @return \Illuminate\Http\Response
     */
    public function destroy(SlideUser $slideUser)
    {
        //
    }
}
