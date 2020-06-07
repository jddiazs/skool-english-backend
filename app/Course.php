<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
  protected $fillable = [
    'slug', 'name', 'author', 'video_url', 'created_by'
  ];
}
