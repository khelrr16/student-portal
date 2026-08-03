<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GoogleSheetResponseService
{
    public function fetch(): array
    {
        $url = 'https://script.google.com/macros/s/AKfycbwe5_lvxDJnITfEk3jstfEApIfzyo9FKGLk-3--owxRMQIGBOCxwmiaNlv8YseKxr0ubA/exec';

        try {
            $response = Http::timeout(10)->get($url);

            if (! $response->successful()) {
                return [
                    'data' => [],
                    'error' => 'Unable to load responses right now. Try again later.',
                ];
            }

            return [
                'data' => collect($response->json())
                    ->filter(fn ($row) => is_array($row))
                    ->map(fn (array $row) => $this->normalizeRow($row))
                    ->values()
                    ->all(),
                'error' => null,
            ];
        } catch (\Throwable $e) {
            report($e);

            return [
                'data' => [],
                'error' => 'Unable to load responses right now. Try again later.',
            ];
        }
    }

    private function normalizeRow(array $row): array
    {
        return collect($row)
            ->mapWithKeys(function ($value, $key) {
                $normalizedKey = is_string($key) ? trim($key) : $key;
                $normalizedValue = is_string($value) ? trim($value) : $value;

                return [$normalizedKey => $normalizedValue];
            })
            ->all();
    }
}