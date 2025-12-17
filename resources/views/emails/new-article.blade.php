<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Новая статья</title>
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
        }
        .header h1 {
            margin: 0;
            font-size: 24px;
        }
        .article-info {
            background-color: #f8f9fa;
            padding: 15px;
            border-radius: 6px;
            margin: 20px 0;
        }
        .article-info p {
            margin: 8px 0;
        }
        .article-info strong {
            color: #667eea;
        }
        .content {
            margin: 20px 0;
            padding: 15px;
            background-color: #f9fafb;
            border-left: 4px solid #667eea;
        }
        .button {
            display: inline-block;
            padding: 12px 30px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            margin-top: 20px;
            font-weight: bold;
        }
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e5e7eb;
            color: #6b7280;
            font-size: 14px;
            text-align: center;
        }
        .image-container {
            text-align: center;
            margin: 20px 0;
        }
        .image-container img {
            max-width: 100%;
            height: auto;
            border-radius: 8px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📰 Новая статья опубликована!</h1>
        </div>

        <p>Здравствуйте!</p>
        <p>На сайте была опубликована новая статья:</p>

        <div class="article-info">
            <p><strong>Название:</strong> {{ $article->title }}</p>
            <p><strong>Автор:</strong> {{ $article->author }}</p>
            <p><strong>Дата публикации:</strong> {{ $article->published_at->format('d.m.Y') }}</p>
            <p><strong>Создана пользователем:</strong> {{ $author->name }} ({{ $author->email }})</p>
        </div>

        @if($article->image)
        <div class="image-container">
            <img src="{{ $article->image }}" alt="{{ $article->title }}">
        </div>
        @endif

        <div class="content">
            <h3 style="margin-top: 0; color: #667eea;">Краткое содержание:</h3>
            <p>{{ Str::limit($article->content, 200) }}</p>
        </div>

        <div style="text-align: center;">
            <a href="{{ route('articles.show', $article->id) }}" class="button">
                Посмотреть статью
            </a>
        </div>

        <div class="footer">
            <p>Это автоматическое уведомление о новой статье.</p>
            <p>&copy; {{ date('Y') }} {{ config('app.name') }}. Все права защищены.</p>
        </div>
    </div>
</body>
</html>