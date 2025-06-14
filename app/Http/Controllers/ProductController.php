<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Resources\ProductResource;
use Inertia\Inertia;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::query()
        ->when($request->category, function ($query) use ($request) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        })
        ->when($request->boolean('special_offers'), function ($query) {
            $query->where('is_special_offer', true);
        })
        ->with('category')
        ->select([
            'id',
            'name',
            'description',
            'price',
            'stock',
            'image',
            'category_id',
            'is_special_offer',
            'offer_expires_at'
        ])
        ->paginate(12);

        $randomSpecialOffer = Product::where('is_special_offer', true)
        ->where(function ($query) {
            $query->whereNull('offer_expires_at')
                  ->orWhere('offer_expires_at', '>', now());
        })
        ->inRandomOrder()
        ->first([
            'id',
            'name',
            'description',
            'price',
            'stock',
            'image',
            'is_special_offer',
            'offer_expires_at'
        ]);

        return Inertia::render('Products', [
            'products' => [
                'data' => $products->getCollection()->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'description' => $product->description,
                        'price' => $product->price,
                        'stock' => $product->stock,
                        'image_url' => $product->image_url, // Assuming you have accessor for this
                        'category_id' => $product->category_id,
                        'is_special_offer' => $product->is_special_offer,
                        'offer_expires_at' => $product->offer_expires_at?->toDateTimeString(),
                        'category_slug' => $product->category->slug
                    ];
                }),
                'current_page' => $products->currentPage(),
                'last_page' => $products->lastPage(),
                'next_page_url' => $products->nextPageUrl(),
                'prev_page_url' => $products->previousPageUrl(),
                'total' => $products->total(),
            ],
            'randomSpecialOffer' => $randomSpecialOffer ? [
                'id' => $randomSpecialOffer->id,
                'name' => $randomSpecialOffer->name,
                'description' => $randomSpecialOffer->description,
                'price' => $randomSpecialOffer->price,
                'stock' => $randomSpecialOffer->stock,
                'image_url' => $randomSpecialOffer->image_url,
                'is_special_offer' => $randomSpecialOffer->is_special_offer,
                'offer_expires_at' => $randomSpecialOffer->offer_expires_at?->toDateTimeString()
            ] : null,
            'categories' => Category::all(['id', 'name', 'slug']),
            'selectedCategory' => $request->category,
            'showSpecialOfferBanner' => !$request->boolean('special_offers') 
                                    && !$request->category 
                                    && $randomSpecialOffer !== null,
        ]);
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'required|exists:categories,id',
            'is_special_offer' => 'sometimes|boolean',
            'offer_expires_at' => 'nullable|date|after:now'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $imagePath = $request->file('image')->store('products', 'public');

        $product = Product::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
            'category_id' => $request->category_id,
            'is_special_offer' => $request->is_special_offer ?? false,
            'offer_expires_at' => $request->offer_expires_at
        ]);

        return response()->json([
            'data' => $product->load('category'),
            'message' => 'Product created successfully'
        ], 201);
    }

    public function show(Product $product)
    {
        // Load related products from the same category
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get(['id', 'name', 'price', 'image', 'is_special_offer']);

        return Inertia::render('Product', [
            'product' => [
                'id' => $product->id,
                'name' => $product->name,
                'description' => $product->description,
                'price' => $product->price,
                'stock' => $product->stock,
                'image_url' => $product->image_url,
                'is_special_offer' => $product->is_special_offer,
                'offer_expires_at' => $product->offer_expires_at?->toDateTimeString(),
                'category' => $product->category->only(['id', 'name', 'slug']),
            ],
            'relatedProducts' => $relatedProducts->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->price,
                    'image_url' => $product->image_url,
                    'is_special_offer' => $product->is_special_offer,
                ];
            }),
        ]);
    }

    public function update(Request $request, Product $product)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'price' => 'sometimes|numeric|min:0',
            'stock' => 'sometimes|integer|min:0',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => 'sometimes|exists:categories,id',
            'is_special_offer' => 'sometimes|boolean',
            'offer_expires_at' => 'nullable|date|after:now'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

        $data = $request->except('image');

        if ($request->hasFile('image')) {
            // Delete old image
            // Storage::disk('public')->delete($product->image);
            
            // // Store new image
            // $imagePath = $request->file('image')->store('products', 'public');
            // $data['image'] = $imagePath;

            $imagePath = $request->file('image')->store('public/products');
            $product->image = str_replace('public/', '', $imagePath);
        }

        $product->update($data);

        return response()->json([
            'data' => $product->load('category'),
            'message' => 'Product updated successfully'
        ]);
    }

    public function destroy(Product $product)
    {
        // Delete associated image
        Storage::disk('public')->delete($product->image);
        
        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully'
        ]);
    }
}
