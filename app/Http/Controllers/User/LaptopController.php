<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Laptop;
use Illuminate\Http\Request;

class LaptopController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $availableOnly = $request->has('available_only');

        $query = Laptop::query();

        
        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('brand', 'like', '%' . $search . '%')
                  ->orWhere('model', 'like', '%' . $search . '%');
            });
        }

        
        if ($availableOnly) {
            $query->where('status', 'tersedia');
        }

        $laptops = $query->orderBy('id', 'desc')->paginate(9)->withQueryString();

        return view('user.laptops.index', compact('laptops', 'search', 'availableOnly'));
    }

    
    public function show(Laptop $laptop)
    {
        return view('user.laptops.show', compact('laptop'));
    }
}
