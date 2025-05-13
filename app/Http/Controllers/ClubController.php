<?php

namespace App\Http\Controllers;

use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class ClubController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Club::class);
        $clubs = Club::latest()->get();
        return Inertia::render('Clubs/Index', [
            'clubs' => $clubs
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Club::class);
        return Inertia::render('Clubs/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create', Club::class);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:clubs',
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean'
        ]);

        if ($request->hasFile('logo')) {
            $validated['logo'] = $request->file('logo')->store('club-logos', 'public');
        }

        Club::create($validated);

        return redirect()->route('clubs.index')->with('success', 'Club created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Club $club)
    {
        $this->authorize('view', $club);
        return redirect()->route('clubs.members.index', $club);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Club $club)
    {
        $this->authorize('update', $club);
        return Inertia::render('Clubs/Edit', [
            'club' => $club
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Club $club)
    {
        $this->authorize('update', $club);
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:clubs,name,' . $club->id,
            'description' => 'nullable|string',
            'logo' => 'nullable|image|max:2048',
            'is_active' => 'required|boolean'
        ]);

        if ($request->hasFile('logo')) {
            if ($club->logo) {
                Storage::disk('public')->delete($club->logo);
            }
            $validated['logo'] = $request->file('logo')->store('club-logos', 'public');
        } else {
            $validated['logo'] = $club->logo;
        }

        $club->update($validated);

        return redirect()->route('clubs.index')->with('success', 'Club updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Club $club)
    {
        $this->authorize('delete', $club);

        if ($club->logo) {
            Storage::disk('public')->delete($club->logo);
        }

        $club->delete();

        return redirect()->route('clubs.index')->with('success', 'Club deleted successfully.');
    }
}
