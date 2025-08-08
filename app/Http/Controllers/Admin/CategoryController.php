<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::orderByDesc('created_at')->get();
        return view('admin.category', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => ['required','string','max:50'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'is_active' => ['nullable','boolean'],
        ]);

        $path = null;
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
        }

        Category::create([
            'name' => $data['name'],
            'is_active' => (bool)($data['is_active'] ?? true),
            'image' => $path,
        ]);

        return redirect()->route('admin.categories.index')->with('ok', 'Tạo danh mục thành công!');
    }

    public function update(Request $request, Category $category)
    {
        $data = $request->validate([
            'name' => ['required','string','max:50'],
            'image' => ['nullable','image','mimes:jpg,jpeg,png,webp','max:2048'],
            'is_active' => ['nullable','boolean'],
        ]);

        // Replace image if a new one is provided
        if ($request->hasFile('image')) {
            if ($category->image) {
                Storage::disk('public')->delete($category->image);
            }
            $category->image = $request->file('image')->store('categories', 'public');
        }

        $category->name = $data['name'];
        if (isset($data['is_active'])) {
            $category->is_active = (bool)$data['is_active'];
        }
        $category->save();

        return redirect()->route('admin.categories.index')->with('ok', 'Cập nhật danh mục thành công!');
    }

    public function toggleActive(Category $category)
    {
        $category->is_active = ! $category->is_active;
        $category->save();
        return redirect()->route('admin.categories.index')->with('ok', 'Cập nhật trạng thái danh mục thành công!');
    }
}