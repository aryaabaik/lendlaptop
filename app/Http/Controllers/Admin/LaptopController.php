<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Laptop;
use App\Models\Category;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index()
    {
        $laptops = Laptop::with('category')
            ->when(request('search'), fn($q) => $q->where('model', 'like', '%'.request('search').'%')
                ->orWhere('brand', 'like', '%'.request('search').'%')
                ->orWhere('code', 'like', '%'.request('search').'%'))
            ->when(request('category'), fn($q) => $q->where('category_id', request('category')))
            ->when(request('status'),   fn($q) => $q->where('status', request('status')))
            ->paginate(10);

        $categories = Category::all();
        return view('admin.laptops.index', compact('laptops', 'categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_id'   => 'required|exists:categories,id',
            'code'          => 'required|unique:laptops,code',
            'brand'         => 'required|string',
            'model'         => 'required|string',
            'processor'     => 'required|string',
            'ram'           => 'required|integer',
            'storage'       => 'required|string',
            'serial_number' => 'required|unique:laptops,serial_number',
            'condition'     => 'required|in:baik,rusak_ringan,rusak_berat',
            'status'        => 'required|in:tersedia,dipinjam,maintenance,rusak',
            'image'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('laptops', 'public');
        }

        Laptop::create($validated);
        return redirect()->route('admin.laptops.index')->with('success', 'Laptop berhasil ditambahkan!');
    }

    public function update(Request $request, Laptop $laptop)
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'brand'       => 'required|string',
            'model'       => 'required|string',
            'processor'   => 'required|string',
            'ram'         => 'required|integer',
            'storage'     => 'required|string',
            'condition'   => 'required',
            'status'      => 'required',
            'image'       => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('laptops', 'public');
        }

        $laptop->update($validated);
        return redirect()->route('admin.laptops.index')->with('success', 'Laptop berhasil diupdate!');
    }

    public function destroy(Laptop $laptop)
    {
        $laptop->delete();
        return redirect()->route('admin.laptops.index')->with('success', 'Laptop berhasil dihapus!');
    }
}