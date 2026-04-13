<?php

namespace App\Http\Controllers;

use App\Models\Equipment;
use App\Models\EquipmentLog;
use Illuminate\Http\Request;

class EquipmentController extends Controller
{
    public function index()
    {
        $equipment = Equipment::all();
        return view('equipment_hub', compact('equipment'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'equipment_id' => 'nullable|exists:equipment,id',
            'equipment_name' => 'required_without:equipment_id|string|max:255',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_numbers' => 'nullable|string',
            'action' => 'required|in:pulled_out,returned',
            'user_name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
        ]);

        if ($request->equipment_id) {
            $equipment = Equipment::find($request->equipment_id);
            $equipmentName = $equipment->name;
            $brand = $equipment->brand;
            $model = $equipment->model;
            $serial_numbers = $request->serial_numbers;
        } else {
            $equipmentName = $request->equipment_name;
            $brand = $request->brand;
            $model = $request->model;
            $serial_numbers = $request->serial_numbers;
            $equipment = Equipment::where('name', $equipmentName)->first();
            
            // Sync with Manage Equipment (Create/Update if it doesn't exist)
            if (!$equipment) {
                // If it was just pulled out, that means we had it but it wasn't tracked. Start with the pulled quantity so it goes to 0 safely.
                $initialQty = $request->action === 'pulled_out' ? $request->quantity : 0;
                $equipment = Equipment::create([
                    'name' => $equipmentName,
                    'brand' => $brand,
                    'model' => $model,
                    'serial_numbers' => $serial_numbers,
                    'quantity' => $initialQty // This will be adjusted below
                ]);
            } else {
                // Optionally update brand/model/serial_numbers if they were provided
                $equipment->update([
                    'brand' => $brand ?: $equipment->brand,
                    'model' => $model ?: $equipment->model,
                    'serial_numbers' => $serial_numbers ?: $equipment->serial_numbers,
                ]);
            }
        }

        if ($equipment && !$equipment->wasRecentlyCreated && $request->action === 'pulled_out') {
            if ($equipment->quantity < $request->quantity) {
                return back()->with('error', 'Not enough quantity available.');
            }
        }

        EquipmentLog::create([
            'equipment_id' => $equipment ? $equipment->id : null,
            'equipment_name' => $equipmentName,
            'brand' => $brand,
            'model' => $model,
            'serial_numbers' => $serial_numbers,
            'user_name' => $request->user_name,
            'action' => $request->action,
            'quantity' => $request->quantity,
        ]);

        if ($equipment) {
            if ($request->action === 'pulled_out') {
                $equipment->decrement('quantity', $request->quantity);
                if ($equipment->fresh()->quantity <= 0) {
                    $equipment->update(['status' => 'pulled_out']);
                }
            } else {
                $equipment->increment('quantity', $request->quantity);
                $equipment->update(['status' => 'available']);
            }
        }

        return back()->with('success', 'Equipment ' . str_replace('_', ' ', $request->action) . ' successfully.');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:equipment,name',
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_numbers' => 'nullable|string',
            'quantity' => 'required|integer|min:1',
        ]);

        Equipment::create([
            'name' => $request->name,
            'brand' => $request->brand,
            'model' => $request->model,
            'serial_numbers' => $request->serial_numbers,
            'quantity' => $request->quantity,
            'status' => 'available',
        ]);

        return back()->with('success', 'Equipment added successfully.');
    }

    public function update(Request $request, Equipment $equipment)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:equipment,name,' . $equipment->id,
            'brand' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial_numbers' => 'nullable|string',
            'quantity' => 'required|integer|min:0',
        ]);

        $status = $request->quantity > 0 ? 'available' : 'pulled_out';
        $equipment->update([
            'name' => $request->name,
            'brand' => $request->brand,
            'model' => $request->model,
            'serial_numbers' => $request->serial_numbers,
            'quantity' => $request->quantity,
            'status' => $status
        ]);
        return back()->with('success', 'Equipment updated successfully.');
    }

    public function destroy(Equipment $equipment)
    {
        $equipment->delete();
        return back()->with('success', 'Equipment deleted successfully.');
    }

    public function logs(Request $request)
    {
        $logs = [];
        $query = Equipment::query();
        
        if ($request->has('search') && $request->search != '') {
            $searchTerm = $request->search;
            $query->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('model', 'like', '%' . $searchTerm . '%')
                  ->orWhere('serial_numbers', 'like', '%' . $searchTerm . '%')
                  ->orWhere('brand', 'like', '%' . $searchTerm . '%');
        }
        
        $equipment = $query->get();
        return view('equipment_logs', compact('logs', 'equipment'));
    }

    public function export()
    {
        $logs = [];
        
        $headers = [
            "Content-type"        => "text/csv",
            "Content-Disposition" => "attachment; filename=equipment_logs.csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];
        
        $callback = function() use($logs) {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date/Time', 'Equipment Name', 'Brand', 'Model', 'Serial Numbers', 'Quantity', 'User', 'Action Taken']);
            
            foreach ($logs as $log) {
                $action = $log->action === 'pulled_out' ? 'Pulled Out' : 'Returned';
                fputcsv($file, [
                    $log->created_at->format('Y-m-d H:i:s'),
                    $log->equipment_name ?? ($log->equipment ? $log->equipment->name : ''),
                    $log->brand ?? ($log->equipment ? $log->equipment->brand : ''),
                    $log->model ?? ($log->equipment ? $log->equipment->model : ''),
                    $log->serial_numbers ?? ($log->equipment ? $log->equipment->serial_numbers : ''),
                    $log->quantity,
                    $log->user_name,
                    $action
                ]);
            }
            
            fclose($file);
        };
        
        return response()->stream($callback, 200, $headers);
    }
}
