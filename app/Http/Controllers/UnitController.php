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

    $type = $request->input('type', 'Listening');
    $color = '#743F95';
    $icon = 'ear.svg';
    switch ($type) {
      case 'Speaking':
        $color = '#FFC400';
        $icon = 'chat.svg';
        break;
      case 'Writing':
        $color = '#6795FC';
        $icon = 'edit.svg';
        break;
      case 'Reading':
        $color = '#FF8752';
        $icon = 'book.svg';
        break;
      case 'Vocabulary':
        $color = '#76D6C7';
        $icon = 'translate.svg';
        break;
    }
    try {
      $data = [
        'name' => $request->input('name'),
        'type' => $type,
        'color' => $color,
        'icon'  => $icon,
        'position' => $request->input('position'),
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

  public function reorderUnits(Request $request) {
    $user = Auth::user();
    if($user->type == '0') {
      return response()->json('Los estudiantes no pueden editar las unidades', 401);
    }

    $data = $request->input('units');
    try {
      if (is_array($data)) {
        foreach ($data as $index => $unit) {
          Unit::where('id', $unit['id'])->update(['position' => $unit['position']]);
        }
      }
      return response()->json($data, 201);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }
  }
}
