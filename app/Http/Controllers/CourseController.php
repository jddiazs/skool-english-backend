<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Course;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class CourseController extends Controller
{
  private $user;
  public function __construct()
  {
    $this->user = Auth::user();
  }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
    public function store(Request $request){
      $user = Auth::user();
      if($user->type == '0') {
        return response()->json('Los estudiantes no pueden crear cursos', 401);
      }

      try {
        $slug = Str::slug($request->input('name'), '-');
        $data = [
          'name' => $request->input('name'),
          'author' => $request->input('author'),
          'slug' => $slug,
          'video_url' => $request->input('video_url'),
          'created_by' => $user->id
        ];
        $course = Course::create($data);
        return response()->json($course, 201);
      } catch (\Exception $e) {
        return response()->json($e->getMessage(), 500);
      }

    }

  /**
   * @param Request $request
   * @return \Illuminate\Http\JsonResponse
   */
  public function index(Request $request)
  {
    $user = Auth::user();
    if($user == '0') {
      return response()->json('Los estudiantes no pueden crear cursos', 401);
    }
    try {
      return response()->json(Course::all(), 200);
    } catch (\Exception $e) {
      return response()->json($e->getMessage(), 500);
    }

  }
}
