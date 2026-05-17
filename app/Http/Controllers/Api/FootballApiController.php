<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class FootballApiController extends Controller
{
    /**
     * Supported API methods based on the provider documentation.
     */
    private const SUPPORTED_METHODS = [
        'Countries',
        'Leagues',
        'Fixtures',
        'H2H',
        'Livescore',
        'Standings',
        'Topscorers',
        'Teams',
        'Players',
        'Videos',
        'Odds',
        'Probabilities',
        'OddsLive',
        'Comments',
        'FullOdds',
    ];

    /**
     * Cache durations in seconds by method.
     */
    private const METHOD_TTL = [
        'Countries' => 43200,
        'Leagues' => 21600,
        'Fixtures' => 300,
        'H2H' => 1800,
        'Livescore' => 30,
        'Standings' => 900,
        'Topscorers' => 900,
        'Teams' => 3600,
        'Players' => 3600,
        'Videos' => 21600,
        'Odds' => 300,
        'Probabilities' => 300,
        'OddsLive' => 20,
        'Comments' => 30,
        'FullOdds' => 300,
    ];

    private const METHOD_SLUGS = [
        'countries' => 'Countries',
        'leagues' => 'Leagues',
        'fixtures' => 'Fixtures',
        'h2h' => 'H2H',
        'livescore' => 'Livescore',
        'standings' => 'Standings',
        'topscorers' => 'Topscorers',
        'teams' => 'Teams',
        'players' => 'Players',
        'videos' => 'Videos',
        'odds' => 'Odds',
        'probabilities' => 'Probabilities',
        'live-odds' => 'OddsLive',
        'live-comments' => 'Comments',
        'full-odds' => 'FullOdds',
    ];

    public function index(Request $request): JsonResponse
    {
        $method = (string) $request->query('met', $request->input('met', ''));

        return $this->respond($request, $method);
    }

    public function byMethod(Request $request, string $method): JsonResponse
    {
        $resolvedMethod = self::METHOD_SLUGS[strtolower($method)] ?? $method;

        return $this->respond($request, $resolvedMethod);
    }

    private function respond(Request $request, string $method): JsonResponse
    {
        if (! in_array($method, self::SUPPORTED_METHODS, true)) {
            throw ValidationException::withMessages([
                'met' => [
                    'The selected met is invalid. Supported methods: '.implode(', ', self::SUPPORTED_METHODS),
                ],
            ]);
        }

        $query = $this->normalizeQuery($request->query());
        $query['met'] = $method;
        $cacheKey = $this->buildCacheKey($method, $query);
        $ttl = self::METHOD_TTL[$method] ?? 300;

        $cached = Cache::get($cacheKey);
        if (is_array($cached) && isset($cached['payload'], $cached['stored_at'])) {
            return response()
                ->json($cached['payload'])
                ->header('X-Data-Source', 'cache')
                ->header('X-Cached-At', (string) $cached['stored_at']);
        }

        $payload = $this->fetchFromProvider($query);

        Cache::put($cacheKey, [
            'payload' => $payload,
            'stored_at' => now()->toIso8601String(),
        ], $ttl);

        return response()
            ->json($payload)
            ->header('X-Data-Source', 'provider');
    }

    private function normalizeQuery(array $query): array
    {
        unset($query['APIkey']);
        ksort($query);

        return $query;
    }

    private function buildCacheKey(string $method, array $query): string
    {
        return 'football_api:'.strtolower($method).':'.hash('sha256', json_encode($query));
    }

    private function fetchFromProvider(array $query): array
    {
        $apiKey = (string) config('services.allsportsapi.key');
        $baseUrl = (string) config('services.allsportsapi.base_url');

        if ($apiKey === '') {
            throw ValidationException::withMessages([
                'APIkey' => ['ALL_SPORTS_API_KEY is missing from environment configuration.'],
            ]);
        }

        $response = Http::timeout((int) config('services.allsportsapi.timeout', 30))
            ->connectTimeout((int) config('services.allsportsapi.connect_timeout', 5))
            ->retry((int) config('services.allsportsapi.retries', 1), 150)
            ->acceptJson()
            ->get($baseUrl, array_merge($query, [
                'APIkey' => $apiKey,
            ]));

        if (! $response->successful()) {
            return [
                'success' => 0,
                'error' => 'Provider request failed.',
                'status' => $response->status(),
                'body' => $response->json() ?? $response->body(),
            ];
        }

        return $response->json() ?? [];
    }
}