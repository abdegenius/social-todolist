<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Todo extends Model
{
    use HasFactory;
    public function user() {
        return $this->belongsTo(User::class);
    }
    public function todo_items() {
        return $this->hasMany(TodoItem::class);
    }
    public function todo_accesses() {
        return $this->hasMany(TodoAccess::class);
    }
}
