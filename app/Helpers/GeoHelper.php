<?php

// app/Helpers/GeoHelper.php
namespace App\Helpers;

use Illuminate\Support\Facades\Http;

class GeoHelper
{
    public static function getLocationFromIP(string $ip): array
    {
        try {
            $response = Http::get("https://ipapi.co/{$ip}/json/");
            if ($response->json('error')) {
                return [
                    'reason' => $response->json('reason'),
                ];
            }
            if ($response->ok()) {
                return $response->json();
            }
        } catch (\Exception $e) {
            dump($e);
            // Log::warning("Falha ao obter geo IP: {$e->getMessage()}");
        }

        return [];
    }
}
