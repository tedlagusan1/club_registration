<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Club;
use App\Models\ClubApplication;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Inertia\Inertia;
use Inertia\Response;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): Response
    {
        $clubs = Club::where('is_active', true)->orderBy('name')->get();

        return Inertia::render('Auth/Register', [
            'clubs' => $clubs
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'student_id' => 'required|string|max:255|unique:' . User::class,
            'course' => 'required|string|max:255',
            'year_level' => 'required|string|max:255',
            'grade' => 'required|string|max:255',
            'club_id' => 'required|exists:clubs,id',
            'id_photo' => 'nullable|image|max:1024',
            'email' => 'required|string|lowercase|email|max:255|unique:' . User::class,
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $idPhotoPath = null;
        if ($request->hasFile('id_photo') && $request->file('id_photo')->isValid()) {
            $idPhotoPath = $request->file('id_photo')->store('id_photos', 'public');
        }

        $user = User::create([
            'name' => $request->name,
            'student_id' => $request->student_id,
            'course' => $request->course,
            'year_level' => $request->year_level,
            'grade' => $request->grade,
            'id_photo' => $idPhotoPath,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            // 'role' is automatically set to 'user' by default
        ]);

        ClubApplication::create([
            'user_id' => $user->id,
            'club_id' => $request->club_id,
            'status' => 'pending',
        ]);

        // Remove automatic login after registration
        // Auth::login($user);

        // Redirect back with success status so frontend can handle redirect to login
        return redirect()->back()->with('status', 'Registration successful! Please log in with your new account. Your club application is pending approval.');
    }
}
