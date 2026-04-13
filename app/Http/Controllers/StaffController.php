<?php

namespace App\Http\Controllers;

use App\Models\Staff;
use App\Models\Office;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index()
    {
        $staff = Staff::with('office')->get();
        return view('staff.index', compact('staff'));
    }

    public function create()
    {
        $offices = Office::all();
        return view('staff.create', compact('offices'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'staff_id_number' => 'required|unique:staff',
            'office_id' => 'required|exists:offices,id',
            'contact_number' => 'nullable|string',
            'team_select' => 'nullable|string'
        ]);

        // If a team was selected from the form, store it in the contact_number column
        if (!empty($data['team_select'])) {
            $data['contact_number'] = $data['team_select'];
        }

        // Remove helper key before creating
        unset($data['team_select']);

        Staff::create($data);
        return redirect()->route('staff.index')->with('success', 'Staff member added.');
    }

    public function edit(Staff $staff)
    {
        $offices = Office::all();
        return view('staff.edit', compact('staff', 'offices'));
    }

    public function update(Request $request, Staff $staff)
    {
        $data = $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'staff_id_number' => 'required|unique:staff,staff_id_number,'.$staff->id,
            'office_id' => 'required|exists:offices,id',
            'contact_number' => 'nullable|string',
            'team_select' => 'nullable|string'
        ]);

        if (!empty($data['team_select'])) {
            $data['contact_number'] = $data['team_select'];
        }
        unset($data['team_select']);

        $staff->update($data);
        return redirect()->route('staff.index')->with('success', 'Staff details updated.');
    }

    public function destroy(Staff $staff)
    {
        $staff->delete();
        return redirect()->route('staff.index')->with('success', 'Staff record deleted.');
    }
}
