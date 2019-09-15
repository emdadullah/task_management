<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title', 'user_id', 'parent_id', 'points', 'is_done'];

    public function user() {
        return $this->belongsTo('App\Models\User') ;
    } 

    public function getAll()
    {
        return static::all();
    }

    public function createTask($data)
    {
        return static::create($data);
    }

    public function updateTask($data)
    {
        return static::create($data);
    }

    public function findTask($id)
    {
        return static::find($id);
    }


    public function deleteTask($id)
    {
        return static::find($id)->delete();
    }
}
