<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
  protected $fillable = [
    'original_name', 'file_size', 'created_by', 'type', 'file_path', 'name'
  ];
}
