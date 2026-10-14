<?php

namespace App\Livewire\Sessions;

use App\Enums\AdmissionSessionStatus;
use App\Models\AdmissionSession;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Sessions')]
class Index extends Component
{
    public string $name = '';

    public string $description = '';

    public string $deadline = '';

    public string $status = 'ACTIVE';

    public bool $showCreateForm = false;

    public function mount(): void
    {
        $this->deadline = now()->addDays(30)->format('Y-m-d\TH:i');
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'deadline' => ['required', 'date', 'after:now'],
            'status' => ['required', Rule::in(array_column(AdmissionSessionStatus::cases(), 'value'))],
        ];
    }

    public function createSession(): void
    {
        $data = $this->validate();

        AdmissionSession::create([
            ...$data,
            'deadline' => Carbon::parse($data['deadline']),
            'public_token' => Str::random(64),
            'created_by' => auth()->id(),
        ]);

        $this->resetForm();
        $this->showCreateForm = false;
        session()->flash('success', 'Admission session created successfully.');
    }

    public function endSession(int $sessionId): void
    {
        AdmissionSession::query()->findOrFail($sessionId)->update([
            'status' => AdmissionSessionStatus::ENDED,
        ]);

        session()->flash('success', 'The admission session has been ended.');
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'description', 'status']);
        $this->deadline = now()->addDays(30)->format('Y-m-d\TH:i');
        $this->resetValidation();
    }

    public function render()
    {
        AdmissionSession::query()
            ->where('status', AdmissionSessionStatus::ACTIVE)
            ->where('deadline', '<', now())
            ->update(['status' => AdmissionSessionStatus::ENDED]);

        return view('livewire.sessions.index', [
            'sessions' => AdmissionSession::query()
                ->withCount('enrollments')
                ->latest()
                ->get(),
        ]);
    }
}
