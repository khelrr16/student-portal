<?php

namespace App\Livewire;

use App\Services\DashboardChartService;
use Livewire\Component;

class DashboardRespondentsChart extends Component
{
    public bool $loading = true;

    public string $errorMessage = '';

    public int $totalRespondents = 0;

    public array $chartLabels = [];

    public array $chartValues = [];

    public function loadChart(DashboardChartService $service): void
    {
        $payload = $service->respondentsByStrand();

        $this->chartLabels = $payload['labels'];
        $this->chartValues = $payload['values'];
        $this->totalRespondents = (int) $payload['total'];
        $this->errorMessage = $payload['error'] ?? '';
        $this->loading = false;

        $this->dispatch('dashboard-respondents-chart-ready',
            canvasId: 'dashboard-respondents-chart',
            labels: $this->chartLabels,
            values: $this->chartValues,
        );
    }

    public function render()
    {
        return view('livewire.dashboard-respondents-chart');
    }
}