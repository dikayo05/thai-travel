<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        if ($type = $request->get('type')) {
            $query->where('type', $type);
        }
        if (!is_null($request->get('active'))) {
            $query->where('is_active', (bool) $request->boolean('active'));
        }

        $products = $query->orderByDesc('created_at')->paginate(15)->withQueryString();

        return view('admin.products.index', compact('products'));
    }

    public function create()
    {
        return view('admin.products.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:car,tour'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:3'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['currency'] = $validated['currency'] ?? 'THB';
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);

        $product = Product::create($validated);

        return redirect()->route('admin.products.edit', $product)->with('status', 'Product created');
    }

    public function edit(Product $product)
    {
        return view('admin.products.edit', compact('product'));
    }

    public function show(Product $product)
    {
        return redirect()->route('admin.products.edit', $product);
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:car,tour'],
            'description' => ['nullable', 'string'],
            'image_url' => ['nullable', 'url'],
            'base_price' => ['required', 'numeric', 'min:0'],
            'discounted_price' => ['nullable', 'numeric', 'min:0'],
            'currency' => ['nullable', 'string', 'max:3'],
            'is_active' => ['nullable', 'boolean'],
            'is_featured' => ['nullable', 'boolean'],
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['currency'] = $validated['currency'] ?? $product->currency ?? 'THB';
        $validated['is_active'] = (bool) ($validated['is_active'] ?? false);
        $validated['is_featured'] = (bool) ($validated['is_featured'] ?? false);

        $product->update($validated);

        return redirect()->route('admin.products.edit', $product)->with('status', 'Product updated');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('admin.products.index')->with('status', 'Product deleted');
    }
}
