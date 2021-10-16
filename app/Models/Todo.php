<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    protected $guarded = [];



    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function permittedUsers()
    {
        return $this->belongsToMany(User::class, "todo_user", "task_id", "user_id");
    }


    public function visibilitytag()
    {
        if ( $this->visibility == 1 )
        {
            return "public";
        }
        if ( $this->visibility == 2 )
        {
            return "only me";
        }
        if ( $this->visibility == 3 )
        {
            return "custom";
        }
    }
}
