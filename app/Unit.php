<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Slide;

class Unit extends Model
{
  protected $fillable = [
    'name', 'type', 'color', 'icon',  'status', 'course_id', 'created_by', 'position'
  ];

  public function slides() {
    return $this->hasMany(Slide::class);
  }

  public function course(){
    return $this->belongsTo(Course::class);
  }

  public function user(){
    return $this->belongsTo(User::class);
  }

  /**
   * @param $id
   * @return mixed
   */
  public static function getUnitsByCourseId($id) {
    $units = self::where('course_id', '=', $id)->get();
    $units = $units->load('formUser');
    return $units->load('slides');
  }
}
