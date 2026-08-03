<?php

namespace App\Services;

use Illuminate\Support\Str;

class DashboardChartService
{
    public function __construct(private GoogleSheetResponseService $responseService)
    {
    }

    public function respondentsByStrand(): array
    {
        $payload = $this->responseService->fetch();

        if (! empty($payload['error'])) {
            return [
                'labels' => [],
                'values' => [],
                'total' => 0,
                'error' => $payload['error'],
            ];
        }

        $counts = collect($payload['data'])
            ->map(fn (array $row) => $this->cleanLabel($row['SHS Strand'] ?? 'Unknown'))
            ->countBy()
            ->sortDesc();

        return [
            'labels' => $counts->keys()->values()->all(),
            'values' => $counts->values()->all(),
            'total' => $counts->sum(),
            'error' => null,
        ];
    }

    private function cleanLabel(mixed $value): string
    {
        $label = Str::of((string) $value)->trim()->replaceMatches('/\s+/', ' ')->toString();

        return $label !== '' ? $label : 'Unknown';
    }
}