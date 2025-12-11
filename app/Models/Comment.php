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
}