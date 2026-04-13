<?php

namespace App\Http\Controllers;

use App\Models\Guard;
use Illuminate\Http\Request;

class GuardController extends Controller
{
    public function index()
    {
        $guards = Guard::all();
        return view('admin.guards.index', compact('guards'));
    }

    public function create()
    {
        return view('admin.guards.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'badge_number' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
        ]);

        Guard::create($request->all());

        return redirect()->route('admin.guards.index')->with('success', 'Guard added successfully.');
    }

    public function edit(Guard $guard)
    {
        return view('admin.guards.edit', compact('guard'));
    }

    public function update(Request $request, Guard $guard)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'badge_number' => 'nullable|string|max:255',
            'contact_number' => 'nullable|string|max:255',
        ]);

        $guard->update($request->all());

        return redirect()->route('admin.guards.index')->with('success', 'Guard updated successfully.');
    }

    public function destroy(Guard $guard)
    {
        $guard->delete();
        return redirect()->route('admin.guards.index')->with('success', 'Guard deleted successfully.');
    }
}
