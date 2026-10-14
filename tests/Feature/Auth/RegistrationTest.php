<?php

use App\Livewire\Users\Index as AdminAccounts;
use App\Models\AdmissionSession;
use App\Models\User;
use Livewire\Livewire;

it('does not expose public account registration', function () {
    $this->get('/register')->assertNotFound();
});

it('allows only the super admin to create admin accounts', function () {
    $superAdmin = User::factory()->create(['role' => 'super_admin']);
    $admin = User::factory()->create(['role' => 'admin']);

    $this->actingAs($superAdmin)->get(route('admin.accounts.index'))->assertOk();
    $this->actingAs($admin)->get(route('admin.accounts.index'))->assertForbidden();

    Livewire::actingAs($superAdmin)
        ->test(AdminAccounts::class)
        ->set('name', 'Admissions Staff')
        ->set('email', 'staff@example.com')
        ->set('password', 'Password-1234')
        ->set('password_confirmation', 'Password-1234')
        ->call('createAdmin')
        ->assertHasNoErrors();

    expect(User::where('email', 'staff@example.com')->value('role'))->toBe('admin');
});

it('requires an uppercase letter and number in admin passwords', function () {
    $superAdmin = User::factory()->create(['role' => 'super_admin']);

    Livewire::actingAs($superAdmin)
        ->test(AdminAccounts::class)
        ->set('name', 'Weak Password User')
        ->set('email', 'weak@example.com')
        ->set('password', 'passwordonly')
        ->set('password_confirmation', 'passwordonly')
        ->call('createAdmin')
        ->assertHasErrors('password');

    expect(User::where('email', 'weak@example.com')->exists())->toBeFalse();
});

it('allows the super admin to delete regular admin accounts', function () {
    $superAdmin = User::factory()->create(['role' => 'super_admin']);
    $admin = User::factory()->create(['role' => 'admin']);

    Livewire::actingAs($superAdmin)
        ->test(AdminAccounts::class)
        ->call('deleteAdmin', $admin->id)
        ->assertHasNoErrors();

    expect(User::whereKey($admin->id)->exists())->toBeFalse();
});

it('protects super admins and admins who own admission sessions from deletion', function () {
    $superAdmin = User::factory()->create(['role' => 'super_admin']);
    $admin = User::factory()->create(['role' => 'admin']);

    Livewire::actingAs($superAdmin)
        ->test(AdminAccounts::class)
        ->call('deleteAdmin', $superAdmin->id)
        ->assertHasNoErrors();

    expect(User::whereKey($superAdmin->id)->exists())->toBeTrue();

    AdmissionSession::create([
        'created_by' => $admin->id,
        'name' => 'Owned Session',
        'description' => 'Session owned by the admin.',
        'deadline' => now()->addWeek(),
        'status' => 'ACTIVE',
        'public_token' => str()->random(40),
    ]);

    Livewire::actingAs($superAdmin)
        ->test(AdminAccounts::class)
        ->call('deleteAdmin', $admin->id)
        ->assertHasNoErrors();

    expect(User::whereKey($admin->id)->exists())->toBeTrue();
});
