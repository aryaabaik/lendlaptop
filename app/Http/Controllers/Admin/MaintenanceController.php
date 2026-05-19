<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laptop;
use App\Models\Maintenance;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $status = $request->input('status', 'all');
        $search = $request->input('search');

        $query = Maintenance::with('laptop');

        // Filter status tab
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        // Search filter (laptop code, brand, model)
        if ($search) {
            $query->whereHas('laptop', function($q) use ($search) {
                $q->where('code', 'like', '%' . $search . '%')
                  ->orWhere('brand', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        // Ambil data counts untuk tab
        $counts = [
            'all'         => Maintenance::count(),
            'pending'     => Maintenance::where('status', 'pending')->count(),
            'in_progress' => Maintenance::where('status', 'in_progress')->count(),
            'completed'   => Maintenance::where('status', 'completed')->count(),
        ];

        $maintenances = $query->orderBy('id', 'desc')->paginate(10)->withQueryString();
        
        // Ambil semua laptop untuk option dropdown form
        $laptops = Laptop::orderBy('brand')->get();

        return view('admin.maintenances.index', compact('maintenances', 'counts', 'status', 'search', 'laptops'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'laptop_id'   => 'required|exists:laptops,id',
            'issue'       => 'required|string|max:1000',
            'repair_cost' => 'nullable|numeric|min:0',
            'status'      => 'required|in:pending,in_progress,completed',
        ]);

        $maintenance = Maintenance::create([
            'laptop_id'   => $validated['laptop_id'],
            'issue'       => $validated['issue'],
            'repair_cost' => $validated['repair_cost'] ?? 0,
            'status'      => $validated['status'],
        ]);

        // Update laptop status accordingly
        $laptop = Laptop::findOrFail($validated['laptop_id']);
        if ($validated['status'] === 'completed') {
            $laptop->update(['status' => 'tersedia']);
        } else {
            $laptop->update(['status' => 'maintenance']);
        }

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Data maintenance laptop berhasil ditambahkan!');
    }

    /**
     * Update status and details of maintenance.
     */
    public function update(Request $request, Maintenance $maintenance)
    {
        $validated = $request->validate([
            'status'      => 'required|in:pending,in_progress,completed',
            'repair_cost' => 'required|numeric|min:0',
            'issue'       => 'required|string|max:1000',
        ]);

        $maintenance->update([
            'status'      => $validated['status'],
            'repair_cost' => $validated['repair_cost'],
            'issue'       => $validated['issue'],
        ]);

        // Update laptop status
        if ($maintenance->laptop) {
            if ($validated['status'] === 'completed') {
                $maintenance->laptop->update(['status' => 'tersedia']);
            } else {
                $maintenance->laptop->update(['status' => 'maintenance']);
            }
        }

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Data maintenance berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Maintenance $maintenance)
    {
        // Kembalikan laptop ke tersedia jika maintenance dihapus
        if ($maintenance->laptop && $maintenance->status !== 'completed') {
            $maintenance->laptop->update(['status' => 'tersedia']);
        }
        
        $maintenance->delete();

        return redirect()->route('admin.maintenances.index')
            ->with('success', 'Data maintenance berhasil dihapus.');
    }
}
