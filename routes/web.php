<?php

use App\Http\Controllers\ProfileController;
use App\Livewire\Dashboard\Index as DashboardIndex;
use App\Livewire\Enrollment\Form as EnrollmentForm;
use App\Livewire\Enrollment\Success as EnrollmentSuccess;
use App\Livewire\Sessions\Index as SessionsIndex;
use App\Livewire\Sessions\Show as SessionsShow;
use App\Livewire\Users\Index as UsersIndex;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return redirect()->route('dashboard');
});


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');

    Route::middleware('admin')->prefix('sessions')->name('sessions.')->group(function () {
        Route::get('/', SessionsIndex::class)->name('index');
        Route::get('/{admissionSession}', SessionsShow::class)->name('show');
    });

    Route::middleware('super_admin')->prefix('admin')->name('admin.')->group(function () {
        Route::get('/accounts', UsersIndex::class)->name('accounts.index');
    });
});

Route::get('/enroll/{token}', EnrollmentForm::class)->name('enroll.create');
Route::get('/enroll/{token}/success/{reference}', EnrollmentSuccess::class)->name('enroll.success');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
