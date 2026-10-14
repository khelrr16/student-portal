<?php

namespace App\Livewire\Enrollment;

use App\Models\AdmissionSession;
use App\Models\Enrollment;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.guest')]
#[Title('Student enrollment')]
class Form extends Component
{
    public string $token = '';

    public ?AdmissionSession $admissionSession = null;

    public string $first_name = '';
    public string $middle_name = '';
    public string $last_name = '';
    public string $extension_name = '';
    public string $sex = '';
    public string $birthday = '';
    public string $birthplace = '';
    public string $nationality = 'Filipino';
    public string $other_nationality = '';
    public string $civil_status = '';
    public string $religion = '';
    public string $contact_number = '';
    public string $address = '';
    public string $lrn = '';
    public string $last_school_attended = '';
    public string $last_year_attended = '';
    public string $highest_educational_attained = '';
    public string $shs_level = '';
    public string $strand = '';

    public function mount(string $token): void
    {
        $this->token = $token;
        $this->loadSession();
    }

    protected function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:100'],
            'middle_name' => ['nullable', 'string', 'max:100'],
            'last_name' => ['required', 'string', 'max:100'],
            'extension_name' => ['nullable', 'in:Jr.,Sr.,II,III,IV'],
            'sex' => ['required', 'in:Male,Female,Prefer not to say'],
            'birthday' => ['required', 'date', 'before:today'],
            'birthplace' => ['required', 'string', 'max:255'],
            'nationality' => ['required', 'in:Filipino,Other'],
            'other_nationality' => ['required_if:nationality,Other', 'nullable', 'string', 'max:100'],
            'civil_status' => ['required', 'in:Single,Married,Widowed,Separated,Annulled'],
            'religion' => ['required', 'string', 'max:100'],
            'contact_number' => ['required', 'regex:/^(?:\+63|0)\d{10}$/'],
            'address' => ['required', 'string', 'max:1000'],
            'lrn' => ['required', 'digits:12'],
            'last_school_attended' => ['required', 'string', 'max:255'],
            'last_year_attended' => ['required', 'string', 'max:20', 'regex:/^\d{4}(?:-\d{4})?$/'],
            'highest_educational_attained' => ['required', 'in:Grade 11,Grade 12'],
            'shs_level' => ['required', 'in:Grade 10,Grade 11'],
            'strand' => ['required', 'in:ICT,HUMSS,ABM,STEM'],
        ];
    }

    public function submit(): void
    {
        $this->loadSession();

        if (! $this->admissionSession?->isOpenForEnrollment()) {
            $this->addError('form', 'This registration session is no longer accepting applications.');

            return;
        }

        $data = $this->validate();

        if ($data['nationality'] === 'Other') {
            $data['nationality'] = $data['other_nationality'];
        }

        unset($data['other_nationality']);

        try {
            $enrollment = DB::transaction(function () use ($data): Enrollment {
                return Enrollment::create([
                    ...$data,
                    'admission_session_id' => $this->admissionSession->id,
                    'reference_code' => $this->newReferenceCode(),
                ]);
            });
        } catch (QueryException $exception) {
            if (str_contains(strtolower($exception->getMessage()), 'unique')) {
                $this->addError('lrn', 'This LRN is already registered for this session.');

                return;
            }

            throw $exception;
        }

        $this->redirectRoute('enroll.success', [
            'token' => $this->token,
            'reference' => $enrollment->reference_code,
        ], navigate: true);
    }

    private function loadSession(): void
    {
        $this->admissionSession = AdmissionSession::query()
            ->where('public_token', $this->token)
            ->firstOrFail();

        $this->admissionSession->closeIfExpired();
    }

    private function newReferenceCode(): string
    {
        do {
            $reference = 'ENR-'.now()->format('Ymd').'-'.Str::upper(Str::random(6));
        } while (Enrollment::where('reference_code', $reference)->exists());

        return $reference;
    }

    public function render()
    {
        return view('livewire.enrollment.form', [
            'isOpen' => $this->admissionSession?->isOpenForEnrollment() ?? false,
        ]);
    }
}
