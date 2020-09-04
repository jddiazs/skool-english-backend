<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Unit;
use App\SlideUser;

class UnitController extends Controller
{
  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function store(Request $request){
    $user = Auth::user();
    if($user->type == '0') {
      return response()->json('Los estudiantes no pueden crear unidades', 403);
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
    $user = Auth::user();
    $slideUser = SlideUser::getSlidesOrderByUnitId($user->id, $id);
    try {
      $units = Unit::getUnitsByCourseId($id);
      $units->toArray();

      foreach ($units as $key => $unit) {
        $unitId = $unit['id'];
        foreach ($unit['slides'] as  $k => $slide ) {
          $slideId = $slide['id'];
          $responseUser = null;
          $statusByUser = null;
          if (isset($slideUser[$unitId][$slideId])) {
            $responseUser = $slideUser[$unitId][$slideId]['response_user'];
            $statusByUser = $slideUser[$unitId][$slideId]['status'];
          }
          $units[$key]['slides'][$k]['response_user'] = $responseUser;
          $units[$key]['slides'][$k]['status_by_user'] = $statusByUser;
        }
      }

      return response()->json($units, 201);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }

  }

  public function reorderUnits(Request $request) {
    $user = Auth::user();
    if($user->type == '0') {
      return response()->json('Los estudiantes no pueden editar las unidades', 403);
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

  /**
   * Display the specified resource.
   *
   * @param  \App\Unit  $unit
   * @return \Illuminate\Http\Response
   */
  public function show(Unit $unit)
  {
    $slides = [];
    $replaceSlide = true;
    $beforePosition = null;
    $unit = $unit->load('slides')->toArray();
    if(is_array($unit['slides'])) {
      foreach ($unit['slides'] as $key => $slide) {
        if(isset($slide['content'])) {
          $unit['slides'][$key]['content'] = json_decode($slide['content'], true);
        }

        if ($beforePosition !== $slide['position']) {
          $slides[$slide['position']] = $unit['slides'][$key];
        } else  {
          $replaceSlide = false;
        }
        $beforePosition = $slide['position'];
      }
      if ($replaceSlide) {
        $unit['slides'] = $slides;
      }
    }
    try {
      return response()->json($unit, 201);
    } catch (ModelNotFoundException $e) {
      return response()->json($e->getMessage(), 500);
    }
  }

  /**
     * Update the specified resource in storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Unit $unit)
    {
      $currentUser = Auth::user();
      if($currentUser->type == '0') {
        return response()->json(['messages' =>'Los estudiantes no pueden editar unidades'], 403);
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
          'icon'  => $icon
        ];
        Unit::where('id', $unit->id)->update($data);
        return response()->json($unit, 201);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Unit  $unit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, Unit $unit)
    {

      $userCurrent = Auth::user();
      if($userCurrent->type == '0') {
        return response()->json('Los estudiantes no pueden eliminar unidades', 403);
      }

      try {
        $unit = $unit->delete();
        return response()->json($unit, 200);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }
    }
}
