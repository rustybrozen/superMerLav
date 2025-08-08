<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    const MAX_IMAGES = 5;

    public function index()
    {
        $products = Product::with(['category','images' => fn($q) => $q->orderByDesc('is_primary')])->orderByDesc('created_at')->get();
        $categories = Category::orderBy('name')->get();
        return view('admin.products', compact('products','categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:100'],
            'short_desc'  => ['nullable','string','max:100'],
            'long_desc'   => ['nullable','string'],
            'price'       => ['required','integer','min:0'],
            'in_price'    => ['nullable','integer','min:0'],
            'quantity'    => ['required','integer','min:0'],
            'category_id' => ['nullable', Rule::exists('categories','id')],
            'is_active'   => ['nullable','boolean'],
            'hot'         => ['nullable','boolean'],
            'images'      => ['nullable','array','max:'.self::MAX_IMAGES],
            'images.*'    => ['image','mimes:jpg,jpeg,png,webp','max:3072'],
        ]);

        $product = Product::create([
            'name'        => $data['name'],
            'short_desc'  => $data['short_desc'] ?? null,
            'long_desc'   => $data['long_desc'] ?? null,
            'price'       => $data['price'],
            'in_price'    => $data['in_price'] ?? null,
            'quantity'    => $data['quantity'],
            'category_id' => $data['category_id'] ?? null,
            'is_active'   => (bool)($data['is_active'] ?? true),
            'hot'         => (bool)($data['hot'] ?? false),
            'image'       => 'assets/uploads/default.jpg',
        ]);


        $primaryPath = $product->image; 
        if ($request->hasFile('images')) {
            $i = 0;
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $isPrimary = ($i === 0);
                $img = $product->images()->create([
                    'image_path' => $path,
                    'is_primary' => $isPrimary,
                ]);
                if ($isPrimary) {
                    $primaryPath = $path;
                }
                $i++;
            }
            $product->update(['image' => $primaryPath]);
        }

        return redirect()->route('admin.products.index')->with('ok', 'Tạo sản phẩm thành công!');
    }

    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => ['required','string','max:100'],
            'short_desc'  => ['nullable','string','max:100'],
            'long_desc'   => ['nullable','string'],
            'price'       => ['required','integer','min:0'],
            'in_price'    => ['nullable','integer','min:0'],
            'quantity'    => ['required','integer','min:0'],
            'category_id' => ['nullable', Rule::exists('categories','id')],
            'is_active'   => ['nullable','boolean'],
            'hot'         => ['nullable','boolean'],
            'images'      => ['nullable','array'],
            'images.*'    => ['image','mimes:jpg,jpeg,png,webp','max:3072'],
            'primary_image_id'   => ['nullable','integer'],
            'remove_image_ids'   => ['nullable','array'],
            'remove_image_ids.*' => ['integer'],
        ]);

     
        if (!empty($data['remove_image_ids'])) {
            $imgsToRemove = $product->images()->whereIn('id', $data['remove_image_ids'])->get();
            foreach ($imgsToRemove as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

      
        $currentCount = $product->images()->count();
        $newCount = $request->hasFile('images') ? count($request->file('images')) : 0;
        if ($currentCount + $newCount > self::MAX_IMAGES) {
            return back()->withErrors(['images' => 'Bạn chỉ chọn tối đa '.self::MAX_IMAGES.' hình cho sản phẩm.'])->withInput();
        }

      
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('products', 'public');
                $product->images()->create(['image_path' => $path, 'is_primary' => false]);
            }
        }

        
        if (!empty($data['primary_image_id'])) {
            $targetId = (int)$data['primary_image_id'];
            if ($product->images()->where('id',$targetId)->exists()) {
                $product->images()->update(['is_primary' => false]);
                $img = $product->images()->where('id',$targetId)->first();
                $img->is_primary = true;
                $img->save();
                $product->image = $img->image_path; 
            }
        } else {
       
            if (!$product->images()->where('is_primary', true)->exists()) {
                $first = $product->images()->first();
                if ($first) {
                    $first->is_primary = true; $first->save();
                    $product->image = $first->image_path;
                }
            }
        }

       
        $product->fill([
            'name'        => $data['name'],
            'short_desc'  => $data['short_desc'] ?? null,
            'long_desc'   => $data['long_desc'] ?? null,
            'price'       => $data['price'],
            'in_price'    => $data['in_price'] ?? null,
            'quantity'    => $data['quantity'],
            'category_id' => $data['category_id'] ?? null,
            'is_active'   => isset($data['is_active']) ? (bool)$data['is_active'] : $product->is_active,
            'hot'         => isset($data['hot']) ? (bool)$data['hot'] : $product->hot,
        ])->save();

        return redirect()->route('admin.products.index')->with('ok', 'Đã cập nhật sản phẩm!');
    }

    public function toggleActive(Product $product)
    {
        $product->is_active = ! $product->is_active;
        $product->save();
        return redirect()->route('admin.products.index')->with('ok', 'Đã cập nhật sản phẩm!');
    }

    public function destroyImage(Product $product, ProductImage $image)
    {
        // Ensure the image belongs to the product
        if ($image->product_id !== $product->id) abort(404);

        $wasPrimary = $image->is_primary;
        Storage::disk('public')->delete($image->image_path);
        $image->delete();

        if ($wasPrimary) {
            $fallback = $product->images()->first();
            if ($fallback) {
                $fallback->is_primary = true; $fallback->save();
                $product->image = $fallback->image_path;
            } else {
                $product->image = 'assets/uploads/default.jpg';
            }
            $product->save();
        }

        return back()->with('ok', 'Đã xóa hình ảnh.');
    }
}