<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MenuCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = MenuCategory::orderBy('order')->get();
        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'order' => 'required|integer|min:0',
        ]);

        MenuCategory::create([
            'name' => $data['name'],
            'order' => $data['order'],
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('admin.categories.index')->with('success', 'Kategori ditambahkan.');
    }
}
