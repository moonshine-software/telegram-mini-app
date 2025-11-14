<?php

declare(strict_types=1);

namespace MoonShine\TlgMiniApp\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Http\Request;
use InvalidArgumentException;
use JsonException;
use MoonShine\Laravel\MoonShineAuth;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response;

class TelegramAuth
{
    /**
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(MoonShineAuth::getGuard()->check()) {
            return $next($request);
        }

        $header = $request->header('X-Authorization', '');

        if (!str_starts_with(strtolower($header), 'tma ')) {
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        }

        try {
            $user = $this->validate(
                substr($header, 4)
            );

            /** @var Authenticatable $authenticatable */
            $authenticatable = MoonShineAuth::getModel()
                ->query()
                ->where('telegram_id', $user['id'])
                ->firstOrFail();

            MoonShineAuth::getGuard()->login($authenticatable);

            return $next($request);
        } catch (Exception $e) {
            return response()->json([
                'message' => $e->getMessage()
            ], 401);
        }
    }

    /**
     * @throws JsonException
     * @throws Exception
     */
    private function validate(string $tma): array
    {
        $token = config('ms-telegram-mini-app.token');

        if (!$token) {
            throw new InvalidArgumentException('Telegram bot token is missing');
        }

        parse_str($tma, $params);

        if (!isset($params['hash'])) {
            throw new RuntimeException('Hash not found in init data');
        }

        $hash = $params['hash'];
        unset($params['hash']);

        if (isset($params['auth_date']) && time() - (int)$params['auth_date'] > 3000) {
            throw new RuntimeException('Init data expired');
        }

        ksort($params);

        $data = [];

        foreach ($params as $key => $value) {
            $data[] = $key . '=' . $value;
        }

        $check = implode("\n", $data);

        $secret = hash_hmac('sha256', $token, 'WebAppData', true);
        $calculated = hash_hmac('sha256', $check, $secret);

        if (!hash_equals($calculated, $hash)) {
            throw new RuntimeException('Invalid init data signature');
        }


        if (!isset($params['user'])) {
            throw new RuntimeException('User not found in init data');
        }

        return json_decode($params['user'], true, 512, JSON_THROW_ON_ERROR);
    }
}
