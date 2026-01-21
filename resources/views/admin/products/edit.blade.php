<x-layouts.admin.app>
    <h1 class="text-2xl font-semibold mb-6">Edit Product</h1>

    <form action="{{ route('admin.products.update', $product) }}" method="POST"
        class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded shadow">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                class="w-full border rounded px-3 py-2" required>
            @error('name')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Type</label>
            <select name="type" class="w-full border rounded px-3 py-2" required>
                <option value="car" @selected(old('type', $product->type) === 'car')>Car</option>
                <option value="tour" @selected(old('type', $product->type) === 'tour')>Tour</option>
            </select>
            @error('type')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Description</label>
            <textarea name="description" rows="4" class="w-full border rounded px-3 py-2">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1">Base Price</label>
                <input type="number" step="0.01" name="base_price"
                    value="{{ old('base_price', $product->base_price) }}" class="w-full border rounded px-3 py-2"
                    required>
                @error('base_price')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Discounted Price</label>
                <input type="number" step="0.01" name="discounted_price"
                    value="{{ old('discounted_price', $product->discounted_price) }}"
                    class="w-full border rounded px-3 py-2">
                @error('discounted_price')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Currency</label>
                <input type="text" name="currency" value="{{ old('currency', $product->currency ?? 'THB') }}"
                    class="w-full border rounded px-3 py-2" maxlength="3">
                @error('currency')
                    <p class="text-red-600 text-sm">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Image URL</label>
            <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                class="w-full border rounded px-3 py-2">
            @error('image_url')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))>
                <span>Active</span>
            </label>
            <label class="inline-flex items-center space-x-2">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))>
                <span>Featured</span>
            </label>
        </div>

        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Update</button>
            <a href="{{ route('admin.products.index') }}"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded">Back</a>
        </div>
    </form>
</x-layouts.admin.app>
