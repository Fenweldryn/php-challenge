<?php

namespace App\Api;

use Illuminate\Support\Facades\Http;

class StooqApi
{
    private static string $urlSufixForJsonResponse = '&f=sd2t2ohlcv&h&e=json';

    public static function getStock(string $stock): string
    {
        try {
            return Http::get(env('STOOQ_API_URL') . $stock . self::$urlSufixForJsonResponse)->body();

        } catch (\Throwable $th) {
            throw $th;
        }

    }
}