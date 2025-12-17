<?php

namespace App\Events;

use App\Models\Article;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class NewArticleEvent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public Article $article;

    /**
     * Create a new event instance.
     */
    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): Channel
    {
        return new Channel('articles');
    }

    /**
     * Данные для отправки
     */
    public function broadcastWith(): array
    {
        return [
            'article' => [
                'id' => $this->article->id,
                'title' => $this->article->title,
                'author' => $this->article->author,
                'published_at' => $this->article->published_at->format('d.m.Y'),
            ]
        ];
    }
}