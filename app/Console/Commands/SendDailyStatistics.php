<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\PageView;
use App\Models\Comment;
use App\Models\User;
use App\Models\Article;
use App\Mail\DailyStatisticsReport;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class SendDailyStatistics extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'statistics:send-daily';

    /**
     * The console command description.
     */
    protected $description = 'Send daily statistics report to moderators';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Collecting statistics...');

        // Общее количество просмотров
        $totalViews = PageView::count();

        // Просмотры за сегодня
        $todayViews = PageView::whereDate('created_at', today())->count();

        // Комментарии за сегодня
        $todayComments = Comment::whereDate('created_at', today())->count();

        // Комментарии на модерации
        $pendingComments = Comment::where('is_approved', false)->count();

        // Топ-5 статей по просмотрам за сегодня
        $topArticles = DB::table('page_views')
            ->whereDate('page_views.created_at', today())
            ->where('page_views.url', 'like', '%/articles/%')
            ->select('page_views.url', DB::raw('count(*) as views_count'))
            ->groupBy('page_views.url')
            ->orderByDesc('views_count')
            ->limit(5)
            ->get()
            ->map(function ($item) {
                // Извлекаем ID статьи из URL
                preg_match('/\/articles\/(\d+)/', $item->url, $matches);
                if (isset($matches[1])) {
                    $article = Article::find($matches[1]);
                    if ($article) {
                        return (object)[
                            'title' => $article->title,
                            'views_count' => $item->views_count,
                        ];
                    }
                }
                return null;
            })
            ->filter()
            ->values()
            ->toArray();

        $this->info("Total views: {$totalViews}");
        $this->info("Today views: {$todayViews}");
        $this->info("Today comments: {$todayComments}");
        $this->info("Pending comments: {$pendingComments}");

        // Получаем всех модераторов
        $moderators = User::whereHas('roles', function ($query) {
            $query->where('name', 'moderator');
        })->get();

        $this->info("Sending emails to {$moderators->count()} moderators...");

        // Отправляем письмо каждому модератору
        foreach ($moderators as $moderator) {
            try {
                Mail::to($moderator->email)->send(
                    new DailyStatisticsReport(
                        $totalViews,
                        $todayViews,
                        $todayComments,
                        $pendingComments,
                        $topArticles
                    )
                );
                $this->info("✓ Email sent to {$moderator->email}");
            } catch (\Exception $e) {
                $this->error("✗ Failed to send email to {$moderator->email}: " . $e->getMessage());
            }
        }

        $this->info('Statistics report sent successfully!');

        return Command::SUCCESS;
    }
}