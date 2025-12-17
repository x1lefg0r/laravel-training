<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ежедневная статистика</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
            color: #333;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            background-color: #f4f4f4;
        }
        .container {
            background-color: #ffffff;
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            border-radius: 8px 8px 0 0;
            margin: -30px -30px 20px -30px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 15px;
            margin: 20px 0;
        }
        .stat-card {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            text-align: center;
            border-left: 4px solid #667eea;
        }
        .stat-card .number {
            font-size: 32px;
            font-weight: bold;
            color: #667eea;
            margin: 10px 0;
        }
        .stat-card .label {
            color: #6b7280;
            font-size: 14px;
        }
        .top-articles {
            margin-top: 30px;
        }
        .top-articles h2 {
            color: #667eea;
            margin-bottom: 15px;
        }
        .article-item {
            background-color: #f9fafb;
            padding: 15px;
            margin-bottom: 10px;
            border-radius: 6px;
            border-left: 3px solid #667eea;
        }
        .article-item .title {
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }
        .article-item .views {
            color: #667eea;
            font-size: 14px;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📊 Ежедневная статистика</h1>
            <p style="margin: 5px 0 0 0; opacity: 0.9;">{{ now()->format('d.m.Y') }}</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="label">Всего просмотров</div>
                <div class="number">{{ number_format($totalViews, 0, ',', ' ') }}</div>
            </div>

            <div class="stat-card">
                <div class="label">Просмотров сегодня</div>
                <div class="number">{{ number_format($todayViews, 0, ',', ' ') }}</div>
            </div>

            <div class="stat-card">
                <div class="label">Новых комментариев</div>
                <div class="number">{{ number_format($todayComments, 0, ',', ' ') }}</div>
            </div>

            <div class="stat-card">
                <div class="label">На модерации</div>
                <div class="number">{{ number_format($pendingComments, 0, ',', ' ') }}</div>
            </div>
        </div>

        @if(count($topArticles) > 0)
        <div class="top-articles">
            <h2>🔥 Топ-5 статей за сегодня</h2>
            @foreach($topArticles as $article)
            <div class="article-item">
                <div class="title">{{ $article->title }}</div>
                <div class="views">👁 {{ $article->views_count }} просмотров</div>
            </div>
            @endforeach
        </div>
        @endif

        <div class="footer">
            <p>Это автоматическое ежедневное сообщение со статистикой сайта.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Все права защищены.</p>
        </div>
    </div>
</body>
</html>