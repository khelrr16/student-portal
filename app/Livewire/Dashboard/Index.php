<?php

namespace App\Livewire\Dashboard;

use App\Models\AdmissionSession;
use App\Models\Enrollment;
use Illuminate\Support\Collection;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Dashboard')]
class Index extends Component
{
    public ?int $selectedSessionId = null;

    public function mount(): void
    {
        if (auth()->user()->isAdmin()) {
            $this->selectedSessionId = AdmissionSession::query()->latest()->value('id');
        }
    }

    public function render()
    {
        $isAdmin = auth()->user()->isAdmin();
        $sessions = $isAdmin
            ? AdmissionSession::query()->withCount('enrollments')->latest()->get()
            : collect();

        $selectedSession = $sessions->firstWhere('id', $this->selectedSessionId);
        $gradeCounts = collect(['Grade 10' => 0, 'Grade 11' => 0]);
        $strandCounts = collect(['ICT' => 0, 'HUMSS' => 0, 'ABM' => 0, 'STEM' => 0]);

        if ($selectedSession) {
            $gradeCounts = $this->countsFor($selectedSession->id, 'shs_level', $gradeCounts);
            $strandCounts = $this->countsFor($selectedSession->id, 'strand', $strandCounts);
        }

        return view('livewire.dashboard.index', [
            'sessions' => $sessions,
            'selectedSession' => $selectedSession,
            'gradeCounts' => $gradeCounts,
            'strandCounts' => $strandCounts,
            'gradeMax' => max(1, ...$gradeCounts->values()->all()),
            'strandMax' => max(1, ...$strandCounts->values()->all()),
            'totalEnrollments' => $selectedSession?->enrollments_count ?? 0,
        ]);
    }

    private function countsFor(int $sessionId, string $column, Collection $options): Collection
    {
        $counts = Enrollment::query()
            ->where('admission_session_id', $sessionId)
            ->selectRaw($column.' as label, COUNT(*) as total')
            ->groupBy($column)
            ->pluck('total', 'label');

        return $options->map(fn (int $value, string $label): int => (int) ($counts[$label] ?? $value));
    }
}
