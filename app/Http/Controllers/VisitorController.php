<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        $visitors = Visitor::all();
        return view('visitors.index', compact('visitors'));
    }

    public function create()
    {
        return view('visitors.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'id_number' => 'nullable|string',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'reason_for_visit' => 'nullable|string|max:500',
        ]);
        Visitor::create($data);
        return redirect()->route('visitors.index')->with('success', 'Visitor registered.');
    }

    public function edit(Visitor $visitor)
    {
        return view('visitors.edit', compact('visitor'));
    }

    public function update(Request $request, Visitor $visitor)
    {
        $data = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'id_number' => 'nullable|string',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'reason_for_visit' => 'nullable|string|max:500',
        ]);
        $visitor->update($data);
        return redirect()->route('visitors.index')->with('success', 'Visitor details updated.');
    }

    public function destroy(Visitor $visitor)
    {
        $visitor->delete();
        return redirect()->route('visitors.index')->with('success', 'Visitor record deleted.');
    }
}
