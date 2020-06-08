<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Unit;

class UnitController extends Controller
{
  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request){
    $user = Auth::user();
    if($user->type == '0') {
      return response()->json('Los estudiantes no pueden crear unidades', 401);
    }

    try {
      $data = [
        'name' => $request->input('name'),
        'course_id' => $request->input('course_id'),
        'created_by' => $user->id
      ];
      $unit = Unit::create($data);
      return response()->json($unit, 201);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  public function getUnitsByCourse(Request $request, $id) {
    try {
      $units = Unit::getUnitsByCourseId($id);
      return response()->json($units, 201);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }

  }
}
