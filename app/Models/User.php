<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'type'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'password' => 'hashed',
    ];


    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    public function todos()
    {
        return $this->hasMany(Todo::class);
    }
    public function todo_items()
    {
        return $this->hasMany(TodoItem::class);
    }
    public function todo_accesses()
    {
        return $this->hasMany(TodoAccess::class);
    }
    public function accessible_todos()
    {
        return $this->belongsToMany(Todo::class, 'todo_accesses')
            ->withPivot('status')
            ->wherePivot('status', '1');
    }
}
