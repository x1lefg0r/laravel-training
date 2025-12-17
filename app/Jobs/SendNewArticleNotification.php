<?php

namespace App\Jobs;

use App\Models\Article;
use App\Models\User;
use App\Mail\NewArticleNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class SendNewArticleNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public Article $article;
    public User $author;

    /**
     * Create a new job instance.
     */
    public function __construct(Article $article, User $author)
    {
        $this->article = $article;
        $this->author = $author;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Получаем всех модераторов
        $moderators = User::whereHas('roles', function ($query) {
            $query->where('name', 'moderator');
        })->get();

        // Отправляем email каждому модератору
        foreach ($moderators as $moderator) {
            try {
                Mail::to($moderator->email)->send(
                    new NewArticleNotification($this->article, $this->author)
                );
                
                Log::info("Email sent to moderator: {$moderator->email}");
            } catch (\Exception $e) {
                Log::error("Failed to send email to {$moderator->email}: " . $e->getMessage());
            }
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("SendNewArticleNotification job failed: " . $exception->getMessage());
    }
}