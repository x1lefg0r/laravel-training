<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    use HasFactory;

    /**
     * Поля, которые можно массово заполнять
     */
    protected $fillable = [
        'title',
        'content',
        'author',
        'published_at',
        'image',
        'views'
    ];

    /**
     * Приведение типов
     */
    protected $casts = [
        'published_at' => 'date',
        'views' => 'integer',
    ];

    /**
     * Отношение: статья имеет много комментариев
     */
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}