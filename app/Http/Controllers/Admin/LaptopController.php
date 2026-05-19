<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index()
    {
        $laptops = Laptop::withCount('borrowings')
            ->with('category')
            ->when(request('search'), function($q) {
                $q->where(function($sub) {
                    $sub->where('model', 'like', '%'.request('search').'%')
                        ->orWhere('brand', 'like', '%'.request('search').'%');
                });
            })
            ->when(request('status'), fn($q) => $q->where('status', request('status')))
            ->paginate(10);

        $categories = \App\Models\Category::orderBy('name', 'asc')->get();

        return view('admin.laptops.index', compact('laptops', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'brand'       => 'required|string|max:255',
            'model'       => 'required|string|max:255',
            'status'      => 'required|in:tersedia,dipinjam',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Laptop::create($validated);
        return redirect()->route('admin.laptops.index')->with('success', 'Laptop berhasil ditambahkan!');
    }

    public function update(Request $request, Laptop $laptop)
    {
        $validated = $request->validate([
            'brand'       => 'required|string|max:255',
            'model'       => 'required|string|max:255',
            'status'      => 'required|in:tersedia,dipinjam',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $laptop->update($validated);
        return redirect()->route('admin.laptops.index')->with('success', 'Laptop berhasil diupdate!');
    }

    public function destroy(Laptop $laptop)
    {
        if ($laptop->status === 'dipinjam') {
            return redirect()->route('admin.laptops.index')->with('error', 'Laptop tidak dapat dihapus karena sedang dipinjam!');
        }

        $laptop->delete();
        return redirect()->route('admin.laptops.index')->with('success', 'Laptop berhasil dihapus!');
    }
}