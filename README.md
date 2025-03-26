#  Telegram Bot —  Nginx, Php-fpm and MySQL ,Certbot


> Минималистичный Telegram-бот, написанный на чистом PHP без фреймворков. Поддерживает команды, работу с балансом пользователей, inline-кнопки и интеграцию через webhook.

## ⚙️ Установка

1. Установите **Docker** и **docker-compose**.
2. Клонируйте репозиторий:

  
```bash

git clone https://github.com/Darod103/telegram_bot.git

cd telegram_bot
```
3. Скопируйте .env файл из шаблона:
```bash
cp .env.example .env
```

4. Откройте файл .env и укажите свои данные:
   - TELEGRAM_BOT_TOKEN — токен вашего Telegram-бота, полученный у [@BotFather](https://t.me/BotFather)
   - DB_HOST, DB_NAME, DB_USER, DB_PASSWORD — параметры подключения к вашей базе данных
   - TELEGRAM_BOT_WEBHOOK_URL — URL-адрес, по которому Telegram будет отправлять запросы (ваш домен, например: `https://yourdomain.com`)
   - TELEGRAM_BOT_LINK — Прямая ссылка на бота (например: `https://t.me/YourBotName`)
5. Измените конфигурацию:
     - Замените домены и email в файле init-letsencrypt.sh.
     - Замените все вхождения example.org на ваш домен в файлах:
	     - config/nginx/app.conf
	     - config/nginx.localhost/app.conf
	 - В docker-compose.yml:
	   - **Раскомментируйте** строку - ./nginx.localhost:/etc/nginx/conf.d
	   - **Закомментируйте** строку - ./nginx:/etc/nginx/conf.d
	  - Сделайте скрипт исполняемым и запустите его:
```bash
chmod +x ./scripts/init-letsencrypt.sh

./scripts/init-letsencrypt.sh
```
> 💡 Для тестирования установите staging=1 в скрипте, чтобы избежать ограничения Let’s Encrypt по количеству запросов.

6. После генерации сертификата:
   - **Закомментируйте** строку - ./nginx.localhost:/etc/nginx/conf.d
   - **Раскомментируйте** строку - ./nginx:/etc/nginx/conf.d в docker-compose.yml
  7. Запустите 
   ```bash
docker-compose up --build -d
```
8. Запустите composer:
```bash
composer instal
```
9. Запустите скрипт установки хука
```bash
php ./scripts/setWebHook.php 
```

### Каталог `src`

  

Содержит основной исходный код приложения, написанный на PHP:

**app/** — Основная логика бота (контроллеры, модели, роутеры и сервисы).

     **Controller/** — Контроллеры, отвечающие за обработку сообщений и команд от пользователей.

     **Model/** — Модели для взаимодействия с базой данных (например, модель пользователя).

     **Router/** — Роутер для обработки входящих сообщений и команд бота.

    **Services/** — Сервисные классы (например, логирование, генерация кнопок и работа с API Telegram).
   **Core/** — Классы и компоненты ядра приложения (например, подключение к базе данных и обработка исключений).


### Каталог `scripts`

  

Содержит вспомогательные скрипты для настройки и обслуживания проекта:

  

- **init-letsencrypt.sh** — Скрипт инициализации и автоматического получения SSL-сертификата от Let's Encrypt с помощью Certbot.

- **clearLogs.php**  — Скрипт для очистки лог-файлов приложения.

- **setWebHook.php** — Скрипт для установки вебхука Telegram (запускаеться один раз).

  

Вы можете добавлять собственные скрипты по мере необходимости.
