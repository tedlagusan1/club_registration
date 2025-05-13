<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubApplication;
use App\Models\User;
use App\Notifications\ClubApplicationStatusUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class ClubApplicationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Policy will filter applications based on role
        $this->authorize('viewAny', ClubApplication::class);

        /** @var User $authUser */
        $authUser = Auth::user();

        // Fetch all applications if admin, otherwise only user's
        $applicationsQuery = ClubApplication::with(['user', 'club']);
        if ($authUser->role !== 'admin') {
            $applicationsQuery->where('user_id', $authUser->id);
        }

        $applications = $applicationsQuery->latest()->get();

        return Inertia::render('Applications/Index', [
            'applications' => $applications,
            'userRole' => $authUser->role
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', ClubApplication::class);
        $clubs = Club::where('is_active', true)->get();
        return Inertia::render('Applications/Create', [
            'clubs' => $clubs
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', ClubApplication::class);
        $validated = $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'reason' => 'nullable|string'
        ]);

        /** @var User $authUser */
        $authUser = Auth::user();
        $validated['user_id'] = $authUser->id;
        $validated['status'] = 'pending';

        ClubApplication::create($validated);

        return redirect()->route('applications.index')->with('success', 'Application submitted successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(ClubApplication $application)
    {
        $this->authorize('view', $application);

        return Inertia::render('Applications/Show', [
            'application' => $application->load(['user', 'club', 'approver'])
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        // Typically not needed for applications, managed via update/status
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClubApplication $application)
    {
        $this->authorize('update', $application);

        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
            'reason' => 'nullable|string'
        ]);

        /** @var User $authUser */
        $authUser = Auth::user();

        if ($validated['status'] === 'approved') {
            $validated['approved_by'] = $authUser->id;
            $validated['approved_at'] = now();

            // Avoid creating duplicate members
            $application->club->members()->firstOrCreate([
                'user_id' => $application->user_id,
            ], [
                'joined_at' => now()
            ]);
        } else {
            // If rejected, ensure no member record exists (or handle inactivation)
            $application->club->members()->where('user_id', $application->user_id)->delete();
            $validated['approved_by'] = null;
            $validated['approved_at'] = null;
        }

        $application->update($validated);

        // Load the relationships needed for the notification
        $application->load(['user', 'club']);

        // Send notification to the applicant
        if ($application->user) { // Ensure user exists
            $application->user->notify(new ClubApplicationStatusUpdated($application));
        }

        return redirect()->route('applications.index')->with('success', 'Application ' . $validated['status'] . ' successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClubApplication $application)
    {
        $this->authorize('delete', $application);
        $application->delete();
        return redirect()->route('applications.index')->with('success', 'Application deleted successfully.');
    }
}
