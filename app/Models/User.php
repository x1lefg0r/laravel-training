<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Пользователь имеет много ролей
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * Проверка наличия роли
     */
    public function hasRole($roleName)
    {
        return $this->roles()->where('name', $roleName)->exists();
    }

    /**
     * Проверка наличия любой из ролей
     */
    public function hasAnyRole($roles)
    {
        return $this->roles()->whereIn('name', $roles)->exists();
    }

    /**
     * Является ли пользователь модератором
     */
    public function isModerator()
    {
        return $this->hasRole('moderator');
    }

    /**
     * Пользователь имеет много комментариев
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}