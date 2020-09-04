<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Unit;
use App\User;

class Course extends Model
{
  protected $fillable = [
    'slug', 'name', 'author', 'video_url', 'created_by'
  ];

  /**
  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  */
  public function units() {
    return $this->hasMany(Unit::class);
  }

  public function user(){
    return $this->belongsTo(User::class, 'created_by');
  }
}
