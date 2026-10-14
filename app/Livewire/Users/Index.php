<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

#[Layout('layouts.app')]
#[Title('Admin accounts')]
class Index extends Component
{
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => [
                'required',
                'confirmed',
                Rules\Password::defaults(),
                'regex:/[A-Z]/',
                'regex:/[0-9]/',
            ],
        ];
    }

    public function createAdmin(): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);

        $data = $this->validate();

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'role' => 'admin',
            'password' => Hash::make($data['password']),
            'email_verified_at' => now(),
        ]);

        $this->resetForm();
        session()->flash('success', 'Admin account created successfully.');
    }

    public function resetForm(): void
    {
        $this->reset(['name', 'email', 'password', 'password_confirmation']);
        $this->resetValidation();
    }

    public function deleteAdmin(int $userId): void
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);

        $admin = User::query()
            ->whereKey($userId)
            ->where('role', 'admin')
            ->first();

        if (! $admin) {
            session()->flash('error', 'Only regular admin accounts can be deleted.');

            return;
        }

        if ($admin->admissionSessions()->exists()) {
            session()->flash('error', 'This admin account cannot be deleted because it owns admission sessions.');

            return;
        }

        $admin->delete();

        session()->flash('success', 'Admin account deleted successfully.');
    }

    public function render()
    {
        abort_unless(auth()->user()?->isSuperAdmin(), 403);

        return view('livewire.users.index', [
            'admins' => User::query()
                ->whereIn('role', ['admin', 'super_admin'])
                ->latest()
                ->get(),
        ]);
    }
}
