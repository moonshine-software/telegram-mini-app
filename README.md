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

#### Usage

#### Set MiniApp url

<YOUR_HOST>/admin/telegram-startapp
