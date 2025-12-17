<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /**
     * Поля, которые можно массово заполнять
     */
    protected $fillable = [
        'article_id',
        'user_id',
        'author',
        'content',
        'is_approved',
    ];

    /**
     * Приведение типов
     */
    protected $casts = [
        'is_approved' => 'boolean',
    ];

    /**
     * Отношение: комментарий принадлежит статье
     */
    public function article()
    {
        return $this->belongsTo(Article::class);
    }

    /**
     * Отношение: комментарий принадлежит пользователю
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope для получения только одобренных комментариев
     */
    public function scopeApproved($query)
    {
        return $query->where('is_approved', true);
    }

    /**
     * Scope для получения комментариев на модерации
     */
    public function scopePending($query)
    {
        return $query->where('is_approved', false);
    }
}