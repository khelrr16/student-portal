<?php

use App\Enums\AdmissionSessionStatus;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Enrollment\Form as EnrollmentForm;
use App\Livewire\Sessions\Show as SessionShow;
use App\Models\AdmissionSession;
use App\Models\Enrollment;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Testing\TestResponse;
use Livewire\Livewire;

function createAdmissionSession(array $attributes = []): AdmissionSession
{
    return AdmissionSession::create(array_merge([
        'name' => 'SHS Admission 2027',
        'description' => 'Senior high school registration',
        'deadline' => now()->addDays(10),
        'status' => AdmissionSessionStatus::ACTIVE,
        'public_token' => str_repeat('a', 64),
        'created_by' => User::factory()->create(['role' => 'admin'])->id,
    ], $attributes));
}

function enrollmentPayload(string $lrn = '123456789012'): array
{
    return [
        'first_name' => 'Jamie',
        'middle_name' => 'Santos',
        'last_name' => 'Reyes',
        'extension_name' => '',
        'sex' => 'Prefer not to say',
        'birthday' => '2009-05-12',
        'birthplace' => 'Quezon City',
        'nationality' => 'Filipino',
        'civil_status' => 'Single',
        'religion' => 'Christianity',
        'contact_number' => '09171234567',
        'address' => '123 School Street, Quezon City',
        'lrn' => $lrn,
        'last_school_attended' => 'Sample Junior High School',
        'last_year_attended' => '2025-2026',
        'highest_educational_attained' => 'Grade 11',
        'shs_level' => 'Grade 11',
        'strand' => 'ICT',
    ];
}

it('allows admins to manage sessions and blocks applicants', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $applicant = User::factory()->create(['role' => 'applicant']);

    $this->actingAs($admin)->get('/sessions')->assertOk();
    $this->actingAs($applicant)->get('/sessions')->assertForbidden();

    Livewire::actingAs($admin)
        ->test(\App\Livewire\Sessions\Index::class)
        ->set('name', 'Grade 11 Intake')
        ->set('deadline', now()->addDays(14)->format('Y-m-d\\TH:i'))
        ->call('createSession')
        ->assertHasNoErrors();

    expect(AdmissionSession::where('name', 'Grade 11 Intake')->exists())->toBeTrue();
});

it('serves public enrollment links and closes ended or expired sessions', function () {
    $active = createAdmissionSession(['public_token' => str_repeat('b', 64)]);
    $this->get(route('enroll.create', $active->public_token))->assertOk();

    $this->get('/enroll/not-a-real-token')->assertNotFound();

    $ended = createAdmissionSession([
        'public_token' => str_repeat('c', 64),
        'status' => AdmissionSessionStatus::ENDED,
    ]);
    $this->get(route('enroll.create', $ended->public_token))
        ->assertOk()
        ->assertSee('Registration is closed');

    $expired = createAdmissionSession([
        'public_token' => str_repeat('d', 64),
        'deadline' => Carbon::yesterday(),
    ]);
    $this->get(route('enroll.create', $expired->public_token))
        ->assertOk()
        ->assertSee('Registration is closed');

    expect($expired->refresh()->status)->toBe(AdmissionSessionStatus::ENDED);
});

it('enforces required form values and rejects duplicate LRN values per session', function () {
    $session = createAdmissionSession(['public_token' => str_repeat('e', 64)]);
    $component = Livewire::test(EnrollmentForm::class, ['token' => $session->public_token]);

    $component
        ->set('contact_number', '123')
        ->set('lrn', '123')
        ->call('submit')
        ->assertHasErrors(['contact_number', 'lrn']);

    Enrollment::create(array_merge(enrollmentPayload(), [
        'admission_session_id' => $session->id,
        'reference_code' => 'ENR-20261015-ABC123',
    ]));

    Livewire::test(EnrollmentForm::class, ['token' => $session->public_token])
        ->set(enrollmentPayload())
        ->call('submit')
        ->assertHasErrors('lrn');

    $secondSession = createAdmissionSession(['public_token' => str_repeat('f', 64)]);
    Livewire::test(EnrollmentForm::class, ['token' => $secondSession->public_token])
        ->set(enrollmentPayload())
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect();

    expect(Enrollment::where('lrn', '123456789012')->count())->toBe(2);
});

it('creates a read-only enrollment record with a reference code', function () {
    $session = createAdmissionSession(['public_token' => str_repeat('g', 64)]);

    Livewire::test(EnrollmentForm::class, ['token' => $session->public_token])
        ->set(enrollmentPayload('987654321098'))
        ->call('submit')
        ->assertHasNoErrors()
        ->assertRedirect(route('enroll.success', [
            'token' => $session->public_token,
            'reference' => Enrollment::firstOrFail()->reference_code,
        ], absolute: false));

    $enrollment = Enrollment::where('lrn', '987654321098')->firstOrFail();
    expect($enrollment->reference_code)->toStartWith('ENR-');
    $this->get(route('enroll.success', [$session->public_token, $enrollment->reference_code]))
        ->assertOk()
        ->assertSee($enrollment->reference_code);
});

it('allows admins to edit sessions and filter and sort enrolled students', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $session = createAdmissionSession(['public_token' => str_repeat('h', 64)]);

    Enrollment::create(array_merge(enrollmentPayload('111111111111'), [
        'first_name' => 'Alex',
        'admission_session_id' => $session->id,
        'reference_code' => 'ENR-20261015-ALEX11',
        'shs_level' => 'Grade 10',
        'strand' => 'ICT',
    ]));
    Enrollment::create(array_merge(enrollmentPayload('222222222222'), [
        'first_name' => 'Bea',
        'admission_session_id' => $session->id,
        'reference_code' => 'ENR-20261015-BEA222',
        'shs_level' => 'Grade 11',
        'strand' => 'HUMSS',
    ]));

    Livewire::actingAs($admin)
        ->test(SessionShow::class, ['admissionSession' => $session])
        ->call('startEditing')
        ->set('editName', 'Updated Admission Session')
        ->set('editDeadline', now()->addDays(20)->format('Y-m-d\\TH:i'))
        ->call('updateSession')
        ->assertHasNoErrors()
        ->set('visibleGrades', ['Grade 10'])
        ->set('visibleStrands', ['ICT'])
        ->call('sortBy', 'last_name')
        ->assertSee('Alex')
        ->assertDontSee('Bea');

    expect($session->refresh()->name)->toBe('Updated Admission Session');
});

it('shows grade and strand counts for the selected dashboard session', function () {
    $admin = User::factory()->create(['role' => 'admin']);
    $session = createAdmissionSession(['public_token' => str_repeat('i', 64)]);

    Enrollment::create(array_merge(enrollmentPayload('333333333333'), [
        'admission_session_id' => $session->id,
        'reference_code' => 'ENR-20261015-CCC333',
        'shs_level' => 'Grade 10',
        'strand' => 'STEM',
    ]));

    Livewire::actingAs($admin)
        ->test(DashboardIndex::class)
        ->set('selectedSessionId', $session->id)
        ->assertSee('Grade 10')
        ->assertSee('STEM')
        ->assertSee('1');
});
