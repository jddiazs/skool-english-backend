<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Slide;

class SlideController extends Controller
{

  public function store(Request $request){
    $user = Auth::user();
    if($user->type == '0') {
      return response()->json('Los estudiantes no pueden crear contenido en las unidades', 401);
    }

    try {
      $data = [
        'content' => $request->input('content'),
        'type' => $request->input('type'),
        'course_id' => $request->input('course_id'),
        'unit_id' => $request->input('unit_id'),
        'created_by' => $user->id
      ];
      $slide = Slide::create($data);
      return response()->json($slide, 201);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }
}
