<?php

namespace App\Livewire\Enrollment;

use App\Models\AdmissionSession;
use App\Models\Enrollment;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('Registration complete')]
class Success extends Component
{
    public AdmissionSession $admissionSession;

    public Enrollment $enrollment;

    public function mount(string $token, string $reference): void
    {
        $this->admissionSession = AdmissionSession::query()
            ->where('public_token', $token)
            ->firstOrFail();

        $this->enrollment = $this->admissionSession
            ->enrollments()
            ->where('reference_code', $reference)
            ->firstOrFail();
    }

    public function render()
    {
        return view('livewire.enrollment.success');
    }
}
