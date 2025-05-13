<?php

use App\Http\Controllers\ProfileController;
use App\Models\ClubMember;
use App\Models\User;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\ClubController;
use App\Http\Controllers\ClubApplicationController;
use App\Http\Controllers\ClubMemberController;

// Redirect root URL to the login page
Route::redirect('/', '/login');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', function () {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $user->load([
            'clubMemberships.club.members.user'
        ]);
        $memberships = $user->clubMemberships;
        return Inertia::render('Dashboard', [
            'memberships' => $memberships
        ]);
    })->name('dashboard');

    // Club Management (Admins)
    Route::resource('clubs', ClubController::class);

    // Club Members (Admins view specific club members)
    Route::get('/clubs/{club}/members', [ClubMemberController::class, 'index'])->name('clubs.members.index');
    Route::delete('/members/{member}', [ClubMemberController::class, 'destroy'])->name('members.destroy');
    // Add update route for members if needed later
    // Route::put('/members/{member}', [ClubMemberController::class, 'update'])->name('members.update');

    // Club Applications (Users apply, Admins manage)
    Route::resource('applications', ClubApplicationController::class)->except(['edit']); // Exclude edit as it's handled by update

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
