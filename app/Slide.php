<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
  protected $fillable = [
    'content', 'type', 'status', 'unit_id', 'course_id', 'created_by', 'position'
  ];

  public function unit(){
    return $this->belongsTo(Unit::class);
  }

  public function user(){
    return $this->belongsTo(User::class);
  }
}
