# Laravel News Portal - Документация проекта

Полнофункциональный новостной портал с системой комментариев, модерацией, уведомлениями в реальном времени и REST API.

---

## Содержание

- [Описание проекта](#описание-проекта)
- [Технологии](#технологии)
- [Функционал](#функционал)
- [Установка и запуск](#установка-и-запуск)
- [Структура проекта](#структура-проекта)
- [API документация](#api-документация)
- [Работа с проектом](#работа-с-проектом)
- [Пользователи по умолчанию](#пользователи-по-умолчанию)
- [Дополнительные возможности](#дополнительные-возможности)

---

## Описание проекта

**Laravel News Portal** — это современное веб-приложение для публикации новостей и статей с полноценной системой управления контентом.

### Основные возможности:

- **Управление статьями** — создание, редактирование, удаление
- **Система комментариев** — с модерацией
- **Ролевая система** — модераторы и читатели
- **Email уведомления** — при создании статей и ежедневная статистика
- **Push-уведомления** — в реальном времени через Pusher
- **REST API** — для интеграции с внешними сервисами
- **Очереди задач** — для асинхронной обработки
- **Планировщик задач** — автоматическая отправка статистики
- **Логирование просмотров** — статистика посещений

---

## 🛠 Технологии

### Backend:
- **Laravel 11** — PHP фреймворк
- **MySQL** — база данных
- **Laravel Sanctum** — API аутентификация
- **Laravel Queue** — очереди задач
- **Laravel Echo** — WebSocket подключения
- **Pusher** — real-time уведомления

### Frontend:
- **Tailwind CSS** — стилизация
- **Vue.js 3** — интерактивные компоненты
- **Vite** — сборка фронтенда
- **Blade** — шаблонизатор Laravel

### Инфраструктура:
- **Docker** — контейнеризация
- **Composer** — управление зависимостями PHP
- **NPM** — управление зависимостями JS

---

## Функционал

### Для всех пользователей:
- Просмотр списка статей с пагинацией
- Просмотр отдельных статей
- Поиск по статьям (через API)

### Для авторизованных пользователей:
- Добавление комментариев (с модерацией)
- Редактирование своих комментариев
- Удаление своих комментариев

### Для модераторов:
- Создание новых статей
- Редактирование любых статей
- Удаление статей
- Модерация комментариев (одобрение/отклонение)
- Получение ежедневной статистики на email
- Push-уведомления о новых статьях

---

## Установка и запуск

### Предварительные требования:

```bash
# Убедись, что установлены:
- Docker Desktop
- Git
```

### Шаг 1: Клонирование и настройка контейнера

```bash
# Создай и запусти Docker контейнер
docker pull ubuntu
docker run -itd -p 8000:8000 -p 5173:5173 --name laravel-project ubuntu

# Подключись к контейнеру
docker exec -it laravel-project bash
```

### Шаг 2: Установка зависимостей в контейнере

```bash
# Обнови пакеты
apt-get update

# Установи PHP и расширения
apt-get install -y php php-mbstring php-xml php-curl php-mysql nano unzip curl

# Установи Composer
curl -sS https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
chmod +x /usr/local/bin/composer

# Установи Node.js
curl -o- https://raw.githubusercontent.com/nvm-sh/nvm/v0.39.0/install.sh | bash
# Перезапусти терминал или выполни:
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
nvm install --lts
```

### Шаг 3: Создание проекта

```bash
# Создай Laravel проект
composer create-project laravel/laravel:^11.0 news-portal
cd news-portal

# Установи зависимости
composer require pusher/pusher-php-server
npm install
npm install vue
npm install --save-dev @vitejs/plugin-vue laravel-echo pusher-js
```

### Шаг 4: Настройка окружения

Создай файл `.env`:

```env
APP_NAME="News Portal"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://localhost:8000

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=your_database
DB_USERNAME=your_username
DB_PASSWORD=your_password

BROADCAST_DRIVER=pusher
QUEUE_CONNECTION=database

MAIL_MAILER=smtp
MAIL_HOST=smtp.mail.ru
MAIL_PORT=465
MAIL_USERNAME=your-email@mail.ru
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=ssl
MAIL_FROM_ADDRESS="your-email@mail.ru"
MAIL_FROM_NAME="${APP_NAME}"

PUSHER_APP_ID=your-app-id
PUSHER_APP_KEY=your-key
PUSHER_APP_SECRET=your-secret
PUSHER_APP_CLUSTER=eu

VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"
```

### Шаг 5: Настройка базы данных

```bash
# Создай таблицы
php artisan migrate

# Заполни тестовыми данными
php artisan db:seed
```

### Шаг 6: Запуск приложения

Открой **3 терминала** в контейнере:

**Терминал 1 - Laravel сервер:**
```bash
php artisan serve
```

**Терминал 2 - Queue Worker:**
```bash
php artisan queue:work
```

**Терминал 3 - Vite (фронтенд):**
```bash
npm run dev
```

**Опционально - Планировщик задач (в 4-м терминале):**
```bash
php artisan schedule:work
```

### Шаг 7: Открой приложение

Открой браузер: **http://localhost:8000**

---

## Структура проекта

```
news-portal/
├── app/
│   ├── Console/
│   │   └── Commands/
│   │       └── SendDailyStatistics.php    # Команда отправки статистики
│   ├── Events/
│   │   └── NewArticleEvent.php            # Событие новой статьи
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── API/                       # API контроллеры
│   │   │   │   ├── AuthController.php
│   │   │   │   ├── ArticleController.php
│   │   │   │   └── CommentController.php
│   │   │   ├── ArticleController.php     # Web контроллеры
│   │   │   ├── AuthController.php
│   │   │   ├── CommentController.php
│   │   │   └── MainController.php
│   │   ├── Middleware/
│   │   │   └── LogPageView.php            # Логирование просмотров
│   ├── Jobs/
│   │   └── SendNewArticleNotification.php # Job отправки email
│   ├── Mail/
│   │   ├── DailyStatisticsReport.php      # Email статистики
│   │   └── NewArticleNotification.php     # Email новой статьи
│   ├── Models/
│   │   ├── Article.php
│   │   ├── Comment.php
│   │   ├── PageView.php
│   │   ├── Role.php
│   │   └── User.php
│   └── Policies/
│       ├── ArticlePolicy.php              # Права на статьи
│       └── CommentPolicy.php              # Права на комментарии
├── config/
│   ├── broadcasting.php                   # Настройки broadcasting
│   └── ...
├── database/
│   ├── factories/                         # Фабрики для тестовых данных
│   ├── migrations/                        # Миграции БД
│   └── seeders/                           # Сидеры
├── resources/
│   ├── js/
│   │   ├── components/
│   │   │   └── NotificationComponent.vue  # Vue компонент уведомлений
│   │   ├── app.js
│   │   └── bootstrap.js                   # Laravel Echo настройка
│   └── views/
│       ├── articles/                      # Шаблоны статей
│       ├── auth/                          # Шаблоны авторизации
│       ├── comments/                      # Шаблоны комментариев
│       ├── emails/                        # Email шаблоны
│       └── layouts/
│           └── app.blade.php              # Главный layout
├── routes/
│   ├── api.php                            # API маршруты
│   ├── console.php                        # Console маршруты
│   └── web.php                            # Web маршруты
├── .env                                   # Переменные окружения
├── composer.json
├── package.json
└── vite.config.js                         # Конфиг Vite
```

---

## 🔌 API документация

### Базовый URL

```
http://localhost:8000/api
```

### Аутентификация

API использует **Bearer Token** аутентификацию через Laravel Sanctum.

После логина/регистрации получаешь токен, который нужно передавать в заголовке:

```
Authorization: Bearer YOUR_TOKEN_HERE
```

---

### Endpoints

#### Аутентификация

**Регистрация**

```http
POST /api/register
Content-Type: application/json

{
    "name": "Имя Пользователя",
    "email": "user@example.com",
    "password": "password123",
    "password_confirmation": "password123"
}
```

**Ответ:**
```json
{
    "success": true,
    "message": "Регистрация прошла успешно",
    "user": {
        "id": 1,
        "name": "Имя Пользователя",
        "email": "user@example.com"
    },
    "token": "1|abcdefghijklmnopqrstuvwxyz..."
}
```

---

**Вход**

```http
POST /api/login
Content-Type: application/json

{
    "email": "user@example.com",
    "password": "password123"
}
```

**Ответ:**
```json
{
    "success": true,
    "message": "Вход выполнен успешно",
    "user": {...},
    "token": "2|xyz123..."
}
```

---

**Выход**

```http
POST /api/logout
Authorization: Bearer YOUR_TOKEN
```

**Ответ:**
```json
{
    "success": true,
    "message": "Выход выполнен успешно"
}
```

---

**Получить текущего пользователя**

```http
GET /api/user
Authorization: Bearer YOUR_TOKEN
```

**Ответ:**
```json
{
    "success": true,
    "user": {
        "id": 1,
        "name": "Модератор",
        "email": "moderator@example.com",
        "roles": [...]
    }
}
```

---

#### Статьи

**Получить список статей**

```http
GET /api/articles
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "current_page": 1,
        "data": [
            {
                "id": 1,
                "title": "Заголовок статьи",
                "content": "Содержимое...",
                "author": "Автор",
                "published_at": "2024-12-13",
                "views": 10,
                "image": "https://...",
                "created_at": "2024-12-13T10:00:00.000000Z"
            }
        ],
        "total": 20,
        "per_page": 9
    }
}
```

---

**Получить одну статью**

```http
GET /api/articles/{id}
```

**Ответ:**
```json
{
    "success": true,
    "data": {
        "id": 1,
        "title": "...",
        "content": "...",
        "comments": [
            {
                "id": 1,
                "content": "Комментарий",
                "author": "Автор",
                "is_approved": true,
                "user": {...}
            }
        ]
    }
}
```

---

**Создать статью** *(только модераторы)*

```http
POST /api/articles
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json

{
    "title": "Новая статья",
    "content": "Содержимое статьи минимум 20 символов",
    "author": "Имя автора",
    "published_at": "2024-12-13",
    "image": "https://example.com/image.jpg"
}
```

**Ответ:**
```json
{
    "success": true,
    "message": "Статья успешно создана",
    "data": {
        "id": 21,
        "title": "Новая статья",
        ...
    }
}
```

---

**Обновить статью** *(только модераторы)*

```http
PUT /api/articles/{id}
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json

{
    "title": "Обновлённый заголовок",
    "content": "Обновлённое содержимое",
    "author": "Автор",
    "published_at": "2024-12-14"
}
```

---

**Удалить статью** *(только модераторы)*

```http
DELETE /api/articles/{id}
Authorization: Bearer YOUR_TOKEN
```

**Ответ:**
```json
{
    "success": true,
    "message": "Статья успешно удалена"
}
```

---

#### Комментарии

**Создать комментарий** *(авторизованные пользователи)*

```http
POST /api/articles/{article_id}/comments
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json

{
    "content": "Текст комментария"
}
```

**Ответ:**
```json
{
    "success": true,
    "message": "Комментарий отправлен на модерацию",
    "data": {
        "id": 10,
        "article_id": 1,
        "user_id": 1,
        "author": "Пользователь",
        "content": "Текст комментария",
        "is_approved": false
    }
}
```

---

**Обновить комментарий** *(автор или модератор)*

```http
PUT /api/comments/{id}
Authorization: Bearer YOUR_TOKEN
Content-Type: application/json

{
    "content": "Обновлённый текст"
}
```

---

**Удалить комментарий** *(автор или модератор)*

```http
DELETE /api/comments/{id}
Authorization: Bearer YOUR_TOKEN
```

---

**Получить комментарии на модерации** *(только модераторы)*

```http
GET /api/comments/moderation
Authorization: Bearer YOUR_TOKEN
```

---

**Одобрить комментарий** *(только модераторы)*

```http
PATCH /api/comments/{id}/approve
Authorization: Bearer YOUR_TOKEN
```

---

**Отклонить комментарий** *(только модераторы)*

```http
DELETE /api/comments/{id}/reject
Authorization: Bearer YOUR_TOKEN
```

---

### HTTP коды ответов

| Код | Значение |
|-----|----------|
| 200 | OK - запрос выполнен успешно |
| 201 | Created - ресурс создан |
| 401 | Unauthorized - требуется авторизация |
| 403 | Forbidden - нет прав доступа |
| 404 | Not Found - ресурс не найден |
| 422 | Validation Error - ошибка валидации |
| 500 | Server Error - ошибка сервера |

---

### Примеры использования в Postman

#### 1. Создай переменные окружения

```
base_url = http://localhost:8000
token = (вставь после логина)
```

#### 2. Используй переменные в запросах

```
{{base_url}}/api/articles
Authorization: Bearer {{token}}
```

#### 3. Импортируй коллекцию

Создай файл `postman_collection.json` с готовыми запросами и импортируй в Postman.

---

## Пользователи по умолчанию

После выполнения `php artisan db:seed` создаются следующие пользователи:

| Email | Пароль | Роль |
|-------|--------|------|
| moderator@example.com | password123 | Модератор |
| reader@example.com | password123 | Читатель |

**Модератор** имеет полный доступ ко всем функциям.

**Читатель** может просматривать статьи и добавлять комментарии.

---

## Работа с проектом

### Создание статьи (Web)

1. Войди как модератор: `moderator@example.com` / `password123`
2. Перейди на страницу "Новости"
3. Нажми "+ Создать статью"
4. Заполни форму и сохрани

### Модерация комментариев (Web)

1. Войди как модератор
2. В навигации появится ссылка "Модерация" (с счётчиком)
3. Одобряй или отклоняй комментарии

### Push-уведомления

Push-уведомления появляются автоматически при создании новой статьи на всех открытых страницах сайта (в правом верхнем углу).

### Email уведомления

- При создании статьи модераторы получают email
- Каждый день (по расписанию) отправляется статистика

### Работа с API

Используй Postman/Insomnia для тестирования API endpoints.

---

## Дополнительные возможности

### Очереди задач

```bash
# Просмотр очереди
php artisan queue:work

# Просмотр failed jobs
php artisan queue:failed

# Повторить failed job
php artisan queue:retry <job-id>
```

### Планировщик задач

```bash
# Запустить планировщик (для разработки)
php artisan schedule:work

# Для продакшна добавь в crontab:
* * * * * cd /path/to/project && php artisan schedule:run >> /dev/null 2>&1
```

### Отправка статистики вручную

```bash
php artisan statistics:send-daily
```

### Очистка кеша

```bash
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
```

### Просмотр маршрутов

```bash
# Все маршруты
php artisan route:list

# Только API
php artisan route:list --path=api

# Только статьи
php artisan route:list --name=articles
```

### Работа с БД через Tinker

```bash
php artisan tinker

# Примеры:
>>> \App\Models\Article::count()
>>> \App\Models\User::where('email', 'moderator@example.com')->first()
>>> \App\Models\Comment::pending()->count()
```

---

## 🐛 Troubleshooting

### Ошибка "Class not found"

```bash
composer dump-autoload
php artisan config:clear
```

### Ошибка "SQLSTATE[HY000] [2002]"

Проверь настройки БД в `.env` и убедись, что MySQL запущен.

### Ошибка "Connection refused" (Vite)

```bash
# Останови npm run dev (Ctrl+C)
npm run build
```

### Push-уведомления не работают

1. Проверь настройки Pusher в `.env`
2. Проверь, что `npm run dev` запущен
3. Проверь консоль браузера на ошибки
4. Убедись, что `VITE_PUSHER_APP_KEY` и `VITE_PUSHER_APP_CLUSTER` указаны

### Очереди не обрабатываются

```bash
php artisan queue:work
```

Должен быть запущен в отдельном терминале.

---

## Лицензия

Этот проект создан в образовательных целях.

---

## Благодарности

- Laravel Framework
- Tailwind CSS
- Vue.js
- Pusher
- Все используемые open-source библиотеки

---
