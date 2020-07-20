<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SlideUser extends Model
{
  protected $fillable = [
    'unit_id', 'course_id', 'user_id', 'status',  'response_user', 'slide_id'
  ];

  public function course(){
    return $this->belongsTo(App\Course::class);
  }

  public function user(){
    return $this->belongsTo(App\User::class);
  }

  public function unit(){
    return $this->belongsTo(App\Unit::class);
  }

  public function Slide(){
    return $this->belongsTo(App\Slide::class );
  }

  public static function getByUserAndSlide($user_id, $slide_id) {
    return self::where('slide_id', '=', $slide_id)->where('user_id', '=', $user_id)->get()->toArray();
  }

  public static function getByUserAndCourse($user_id, $course_id) {
    return self::where('course_id', '=', $course_id)->where('user_id', '=', $user_id)->get()->toArray();
  }

  public static function getSlidesOrderByUnitId($user_id, $course_id) {
    $slidesUsers = self::getByUserAndCourse($user_id, $course_id);
    $slidesUserOrderedByUnit = [];
    foreach ($slidesUsers as $slideUser) {
      if(isset($slidesUserOrderedByUnit[$slideUser['unit_id']])) {
        $slidesUserOrderedByUnit[$slideUser['unit_id']][$slideUser['slide_id']] = $slideUser;
      } else {
        $slidesUserOrderedByUnit[$slideUser['unit_id']] = [];
        $slidesUserOrderedByUnit[$slideUser['unit_id']][$slideUser['slide_id']] = $slideUser;
      }
    }

    return $slidesUserOrderedByUnit;
  }


}
