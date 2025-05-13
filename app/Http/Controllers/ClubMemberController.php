<?php

namespace App\Http\Controllers;

use App\Models\Club;
use App\Models\ClubMember;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ClubMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Club $club)
    {
        // Authorize viewing members of this specific club
        $this->authorize('viewAny', [ClubMember::class, $club]);

        $members = $club->members()->with('user')->get();
        return Inertia::render('Members/Index', [
            'club' => $club,
            'members' => $members
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ClubMember $member)
    {
        $this->authorize('update', $member);

        $validated = $request->validate([
            'position' => 'nullable|string|max:255',
            'is_active' => 'boolean'
        ]);

        $member->update($validated);

        return redirect()->route('clubs.members.index', $member->club)
            ->with('success', 'Member updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ClubMember $member)
    {
        $this->authorize('delete', $member);

        $member->delete();

        return redirect()->route('clubs.members.index', $member->club)
            ->with('success', 'Member removed successfully.');
    }
}
