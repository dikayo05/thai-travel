<x-layouts.admin.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Cars & Tours</h1>
        <a href="{{ route('admin.products.create') }}"
            class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Create Product</a>
    </div>

    <form method="GET" class="mb-4 grid grid-cols-1 md:grid-cols-3 gap-4">
        <div>
            <label class="block text-sm font-medium mb-1">Type</label>
            <select name="type" class="w-full border rounded px-3 py-2">
                <option value="">All</option>
                <option value="car" @selected(request('type') === 'car')>Car</option>
                <option value="tour" @selected(request('type') === 'tour')>Tour</option>
            </select>
        </div>
        <div>
            <label class="block text-sm font-medium mb-1">Active</label>
            <select name="active" class="w-full border rounded px-3 py-2">
                <option value="">All</option>
                <option value="1" @selected(request('active') === '1')>Active</option>
                <option value="0" @selected(request('active') === '0')>Inactive</option>
            </select>
        </div>
        <div class="flex items-end">
            <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">Filter</button>
        </div>
    </form>

    <div class="bg-white dark:bg-gray-800 shadow rounded overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium">Price</th>
                    <th class="px-6 py-3 text-left text-xs font-medium">Active</th>
                    <th class="px-6 py-3 text-left text-xs font-medium">Featured</th>
                    <th class="px-6 py-3 text-right text-xs font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($products as $product)
                    <tr>
                        <td class="px-6 py-3">{{ $product->name }}</td>
                        <td class="px-6 py-3">{{ ucfirst($product->type) }}</td>
                        <td class="px-6 py-3">{{ $product->currency }} {{ number_format($product->final_price, 2) }}
                        </td>
                        <td class="px-6 py-3">{{ $product->is_active ? 'Yes' : 'No' }}</td>
                        <td class="px-6 py-3">{{ $product->is_featured ? 'Yes' : 'No' }}</td>
                        <td class="px-6 py-3 text-right space-x-2">
                            <a href="{{ route('admin.products.edit', $product) }}"
                                class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">Edit</a>
                            <form action="{{ route('admin.products.destroy', $product) }}" method="POST"
                                class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                    onclick="return confirm('Delete this product?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-6 py-6 text-center text-gray-500">No products found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $products->links() }}</div>
</x-layouts.admin.app>
