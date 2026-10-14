<?php

namespace App\Livewire\Sessions;

use App\Enums\AdmissionSessionStatus;
use App\Models\AdmissionSession;
use Illuminate\Support\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;
use Livewire\WithPagination;

#[Layout('layouts.app')]
#[Title('Session details')]
class Show extends Component
{
    use WithPagination;

    public AdmissionSession $admissionSession;

    public string $search = '';

    public ?int $selectedEnrollmentId = null;

    public bool $showFilters = false;

    public array $visibleGrades = ['Grade 10', 'Grade 11'];

    public array $visibleStrands = ['ICT', 'HUMSS', 'ABM', 'STEM'];

    public string $sortField = 'created_at';

    public string $sortDirection = 'desc';

    public bool $showEditForm = false;

    public string $editName = '';

    public string $editDescription = '';

    public string $editDeadline = '';

    public function mount(AdmissionSession $admissionSession): void
    {
        $this->admissionSession = $admissionSession;
        $this->admissionSession->closeIfExpired();
    }

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedVisibleGrades(): void
    {
        $this->resetPage();
    }

    public function updatedVisibleStrands(): void
    {
        $this->resetPage();
    }

    public function toggleFilters(): void
    {
        $this->showFilters = ! $this->showFilters;
    }

    public function sortBy(string $field): void
    {
        abort_unless(in_array($field, ['last_name', 'lrn', 'shs_level', 'strand', 'created_at'], true), 422);

        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }

        $this->resetPage();
    }

    public function startEditing(): void
    {
        $this->editName = $this->admissionSession->name;
        $this->editDescription = $this->admissionSession->description ?? '';
        $this->editDeadline = $this->admissionSession->deadline->format('Y-m-d\\TH:i');
        $this->showEditForm = true;
        $this->resetValidation();
    }

    public function cancelEditing(): void
    {
        $this->showEditForm = false;
        $this->resetValidation();
    }

    public function updateSession(): void
    {
        $data = $this->validate([
            'editName' => ['required', 'string', 'max:255'],
            'editDescription' => ['nullable', 'string', 'max:2000'],
            'editDeadline' => ['required', 'date'],
        ]);

        $this->admissionSession->update([
            'name' => $data['editName'],
            'description' => $data['editDescription'],
            'deadline' => Carbon::parse($data['editDeadline']),
        ]);

        $this->admissionSession->refresh();
        $this->admissionSession->closeIfExpired();
        $this->showEditForm = false;
        session()->flash('success', 'The admission session was updated successfully.');
    }

    public function endSession(): void
    {
        $this->admissionSession->update([
            'status' => AdmissionSessionStatus::ENDED,
        ]);

        session()->flash('success', 'The admission session has been ended.');
    }

    public function selectEnrollment(int $enrollmentId): void
    {
        abort_unless(
            $this->admissionSession->enrollments()->whereKey($enrollmentId)->exists(),
            404
        );

        $this->selectedEnrollmentId = $enrollmentId;
    }

    public function closeEnrollmentDetails(): void
    {
        $this->selectedEnrollmentId = null;
    }

    public function render()
    {
        $this->admissionSession->closeIfExpired();

        $students = $this->admissionSession
            ->enrollments()
            ->when($this->search !== '', function (Builder $query): void {
                $term = '%'.trim($this->search).'%';

                $query->where(function (Builder $query) use ($term): void {
                    $query->where('first_name', 'like', $term)
                        ->orWhere('middle_name', 'like', $term)
                        ->orWhere('last_name', 'like', $term)
                        ->orWhere('lrn', 'like', $term)
                        ->orWhere('contact_number', 'like', $term)
                        ->orWhere('reference_code', 'like', $term);
                });
            })
            ->whereIn('shs_level', $this->visibleGrades)
            ->whereIn('strand', $this->visibleStrands)
            ->orderBy($this->sortField, $this->sortDirection)
            ->paginate(12);

        $selectedEnrollment = $this->selectedEnrollmentId
            ? $this->admissionSession->enrollments()->find($this->selectedEnrollmentId)
            : null;

        return view('livewire.sessions.show', [
            'students' => $students,
            'selectedEnrollment' => $selectedEnrollment,
            'registrationUrl' => route('enroll.create', ['token' => $this->admissionSession->public_token]),
            'gradeOptions' => ['Grade 10', 'Grade 11'],
            'strandOptions' => ['ICT', 'HUMSS', 'ABM', 'STEM'],
        ]);
    }
}
