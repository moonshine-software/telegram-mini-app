### Telegram MiniApp integration for MoonShine

## Requirements

- MoonShine 3+
- Laravel 10+
- PHP 8.2+

#### Installation

```shell
composer require moonshine/telegram-mini-app
```

```shell
php artisan vendor:publish --provider="MoonShine\TlgMiniApp\Providers\TlgMiniAppServiceProvider"
```

```dotenv
TELEGRAM_BOT_TOKEN=<TOKEN_HERE>
```
Использование плагина требует наличие поля telegram_id в таблице используемой для хранения пользователей. Если используется таблица по умолчанию (moonshine_users) то достаточно просто выполнить миграции 
```shell
php artisan migrate
```
Если используется не стандартная таблица, то необходимо найти миграцию [2025_10_31_144332_add_telegram_id_to_moonshine_users.php](database/migrations/2025_10_31_144332_add_telegram_id_to_moonshine_users.php) и заменить в ней название таблицы moonshine_users на используемую Вами
#### Usage

#### Set MiniApp url

<YOUR_HOST>/<MOONSHINE_ROUTE_PREFIX>/telegram-startapp
