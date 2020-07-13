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
        'position' => $request->input('position'),
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

  public function edit(Request $request, $id) {
    $user = Auth::user();
    if($user->type == '0') {
      return response()->json('Los estudiantes no pueden editar contenido en las unidades', 401);
    }

    try {
      Slide::where('id', $id)->update(['content' => $request->input('content')]);
      $slide = Slide::find($id);
      return response()->json($slide, 201);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  public function delete(Request $request, $id) {
    $user = Auth::user();
    if($user->type == '0') {
      return response()->json('Los estudiantes no eliminar editar contenido en las unidades', 401);
    }

    try {
      $slide = Slide::where('id', $id)->delete();
      return response()->json($slide, 201);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  public function reorderSlides(Request $request) {
    $user = Auth::user();
    if($user->type == '0') {
      return response()->json('Los estudiantes no pueden editar las unidades', 401);
    }

    $data = $request->input('slides');
    try {
      if (is_array($data)) {
        foreach ($data as $index => $slide) {
          Slide::where('id', $slide['id'])->update(['position' => $slide['position']]);
        }
      }
      return response()->json($data, 201);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }
}
