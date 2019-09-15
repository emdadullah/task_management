<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
     // A user can have multiple posts
    public function tasks() {
        return $this->hasMany('App\Model\Task');
    }

}
