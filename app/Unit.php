<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Slide;

class Unit extends Model
{
  protected $fillable = [
    'name', 'status', 'course_id', 'created_by'
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

  public static function getUnitsByCourseId($id) {
    $units = self::where('course_id', '=', $id)->get();
    return $units->load('slides');
  }
}
