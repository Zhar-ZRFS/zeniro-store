<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::withCount('products')->get();
        
        $query = Product::with('categories')
            ->where('is_active', true)
            ->where('stock', '>', 0);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                ->orWhere('description', 'like', '%' . $search . '%');
            });
        }

        // Filter by category
        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->paginate(8)->withQueryString();
        
        $selectedCategory = $request->category;

        return view('products.index', compact('products', 'categories', 'selectedCategory'));
    }

    public function show($slug)
    {
        $product = Product::with('categories')
            ->where('slug', $slug)
            ->where('is_active', true)
            ->firstOrFail();

        return view('products.show', compact('product'));
    }

    public function getDetail($id)
{
    $product = Product::with('categories')->findOrFail($id);
    
    return response()->json([
        'success' => true,
        'product' => [
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'description' => $product->description,
            'price' => $product->price,
            'price_formatted' => 'Rp ' . number_format($product->price, 0, ',', '.'),
            'stock' => $product->stock,
            'image' => $product->image ? asset('storage/' . $product->image) : null,
            'categories' => $product->categories->pluck('name')->toArray()
        ]
    ]);
}
}