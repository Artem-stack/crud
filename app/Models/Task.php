<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

   protected $fillable = ['title', 'description', 'status', 'priority', 'parent_id', 'user_id'];

    public function subtasks()
    {
        return $this->hasMany(Task::class, 'parent_id');
    }

    public function user()
{
    return $this->belongsTo(User::class);
}

    public function canMarkAsDone()
{
    if ($this->status === 'done') {
        // Завдання вже виконано
        return false;
    }
    
    if ($this->subtasks->where('status', 'todo')->isNotEmpty()) {
        // Є невиконані підзавдання
        return false;
    }

    return true;
}


    public function parent()
    {
        return $this->belongsTo(Task::class, 'parent_id');
    }
}
