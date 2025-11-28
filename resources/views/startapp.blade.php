<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Telegram login</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="url" content="{{ route('moonshine.telegram-login') }}">
    <meta name="config-disable_vertical_swipes" content="{{ config('ms-telegram-mini-app.disable_vertical_swipes')  }}" >
    @vite('main.ts', 'vendor/ms-telegram-mini-app')
</head>
<body></body>
</html>
