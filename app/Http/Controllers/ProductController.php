<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{


    public function shop(Request $request)
    {
        $filters = $this->getFiltersFromRequest($request);
        $products = $this->getFilteredProducts($filters);
        $categories = $this->getCategoriesWithCounts($filters['search']);
        $priceStats = $this->getPriceStatistics($filters);
        return view('shop.shop', compact('products', 'categories', 'priceStats'));
    }

    private function getFiltersFromRequest($request)
    {
        return [
            'sort' => $request->get('sort'),
            'category' => $request->get('category'),
            'min_price' => $request->get('min_price'),
            'max_price' => $request->get('max_price'),
            'search' => $request->get('q'),
        ];
    }


    private function applySearchFilter($query, $searchQuery)
    {
        if (empty(trim($searchQuery))) {
            return $query; 
        }

        return $query->where(function ($q) use ($searchQuery) {
            $q->where('name', 'LIKE', "%{$searchQuery}%")
                ->orWhereHas('category', function ($categoryQuery) use ($searchQuery) {
                    $categoryQuery->where('name', 'LIKE', "%{$searchQuery}%");
                });
        });
    }

    private function applyPriceFilters($query, $minPrice, $maxPrice)
    {
        if (!empty($minPrice)) {
            $query->where('price', '>=', $minPrice);
        }

        if (!empty($maxPrice)) {
            $query->where('price', '<=', $maxPrice);
        }

        return $query;
    }

  
    private function applySorting($query, $sort)
    {
        $query->orderByRaw('quantity = 0');

        switch ($sort) {
            case 'price_asc':
                return $query->orderBy('price', 'asc');
            case 'price_desc':
                return $query->orderBy('price', 'desc');
            case 'name_asc':
                return $query->orderBy('name', 'asc');
            case 'name_desc':
                return $query->orderBy('name', 'desc');
            default:
                return $query->orderBy('created_at', 'desc'); 
        }
    }

    private function getFilteredProducts($filters)
    {
        $query = Product::where('is_active', true);
        $query = $this->applySearchFilter($query, $filters['search']);

        if ($filters['category']) {
            $query->where('category_id', $filters['category']);
        }
        $query = $this->applyPriceFilters($query, $filters['min_price'], $filters['max_price']);
        $query = $this->applySorting($query, $filters['sort']);

        return $query->paginate(12)->withQueryString();
    }

    private function getCategoriesWithCounts($searchQuery = null)
    {
        return Category::withCount([
            'products' => function ($query) use ($searchQuery) {
                $query->where('is_active', true);
                if (!empty(trim($searchQuery))) {
                    $query->where('name', 'LIKE', "%{$searchQuery}%");
                }
            }
        ])->get();
    }

    private function getPriceStatistics($filters)
    {
        $query = Product::where('is_active', true);
        $query = $this->applySearchFilter($query, $filters['search']);

        if ($filters['category']) {
            $query->where('category_id', $filters['category']);
        }

        return $query->selectRaw('MIN(price) as min_price, MAX(price) as max_price, AVG(price) as avg_price')
            ->first();
    }

    public function getCategoriesAjax(Request $request)
    {
        $search = $request->get('search', '');

        $categories = Category::when($search, function ($query, $search) {
            return $query->where('name', 'LIKE', "%{$search}%");
        })
            ->withCount([
                'products' => function ($query) {
                    $query->where('is_active', true);
                }
            ])
            ->get();

        return response()->json($categories);
    }

    public function detail(Product $product)
    {
        return view('shop.detail', compact('product'));
    }
}