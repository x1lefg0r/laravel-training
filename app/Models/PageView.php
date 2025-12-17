<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageView extends Model
{
    use HasFactory;

    protected $fillable = [
        'url',
        'ip',
        'user_agent',
        'user_id',
    ];

    /**
     * Отношение с пользователем
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}