<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    protected $fillable = [
        'unit_id', 'course_id', 'user_id', 'from_user_id', 'from_user_name',  'messages', 'slide_id', 'to_user_id', 'to_user_id', 'parent_id', 'status'
      ];

  /**
   * The User that belong to the messages.
   */
  public function fromUser()
  {
    return $this->belongsTo(User::class, 'from_user_id', 'id');
  }

  /**
  * @return \Illuminate\Database\Eloquent\Relations\HasMany
  */
  public function children() {
    return $this->hasMany(Message::class, 'parent_id');
  }
}
