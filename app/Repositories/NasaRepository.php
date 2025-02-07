<?php

namespace App\Repositories;

use App\Interfaces\NasaRepositoryInterface;
use Illuminate\Support\Facades\Http;

class NasaRepository implements NasaRepositoryInterface
{
    protected string $apiKey;
    protected string $baseUrl;
    protected array $endpoints = [
        'CME',
        'CMEAnalysis',
        'GST',
        'IPS',
        'FLR',
        'SEP',
        'MPC',
        'RBE',
        'HSS',
        'WSAEnlilSimulations',
        'notifications',
    ];

    public function __construct()
    {
        $this->apiKey = config('services.nasa.api_key');
        $this->baseUrl = config('services.nasa.base_url');
    }

    public function fetchData(array $endpoints): array
    {
        $responses = Http::pool(fn($pool) => array_map(
            fn($endpoint) => $pool->async()->withoutVerifying()->get("{$this->baseUrl}/{$endpoint}", [
                'api_key' => $this->apiKey
            ]),
            $endpoints
        ));

        $results = [];
        foreach ($responses as $response) {
            if ($response->successful()) {
                $results = array_merge($results, $response->json());
            }
        }
        return $results;
    }

    public function getInstruments(): array
    {
        $instruments = [];
        $data = $this->fetchData($this->endpoints);
        foreach ($data as $item) {
            if (isset($item['instruments'])) {
                foreach ($item['instruments'] as $instrument) {
                    if (!isset($instrument['displayName'])) continue;
                    $instruments[] = $instrument['displayName'];
                }
            }
        }
        return $instruments;
    }

    public function getActivityIds(): array
    {
        $activityIds = [];
        $data = $this->fetchData($this->endpoints);
        foreach ($data as $item) {
            if (isset($item['linkedEvents'])) {
                foreach ($item['linkedEvents'] as $event) {
                    if (isset($event['activityID'])) {
                        $activityIds[] = substr($event['activityID'], -7);
                    }
                }
            }
        }
        return $activityIds;
    }

    public function getInstrumentUsage(): array
    {
        $instrumentCount = [];
        $data = $this->fetchData($this->endpoints);
        foreach ($data as $item) {
            if (isset($item['instruments'])) {
                foreach ($item['instruments'] as $instrument) {
                    if (isset($instrument['displayName'])) {
                        $instrumentCount[$instrument['displayName']] = ($instrumentCount[$instrument['displayName']] ?? 0) + 1;
                    }
                }
            }
        }
        $total = array_sum($instrumentCount);
        return $total ? array_map(fn($count) => round($count / $total, 2), $instrumentCount) : [];
    }

    public function getInstrumentUsageByName(string $instrument): array
    {
        $activities = [];
        $data = $this->fetchData($this->endpoints);

        foreach ($data as $item) {
            if (!isset($item['linkedEvents']) || !isset($item['instruments'])) {
                continue;
            }
            foreach ($item['linkedEvents'] as $event) {
                if (!isset($event['activityID'])) {
                    continue;
                }

                $activityID = substr($event['activityID'], -7);

                foreach ($item['instruments'] as $instrumentAux) {
                    if (!isset($instrumentAux['displayName'])) {
                        continue;
                    }

                    if ($instrumentAux['displayName'] === $instrument) {
                        $activities[$activityID] = ($activities[$activityID] ?? 0)  + 1;
                        break;
                    }
                }
            }
        }

        $total = array_sum($activities);
        return $total ? array_map(fn($count) => round($count / $total, 2), $activities) : [];
    }
}
