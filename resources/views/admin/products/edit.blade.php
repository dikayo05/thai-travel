<x-layouts.admin.app>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Product</h1>
    </div>

    <form action="{{ route('admin.products.update', $product) }}" method="POST"
        class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', $product->name) }}"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500"
                required>
            @error('name')
                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Type</label>
            <select name="type"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500"
                required>
                <option value="car" @selected(old('type', $product->type) === 'car')>Car</option>
                <option value="tour" @selected(old('type', $product->type) === 'tour')>Tour</option>
            </select>
            @error('type')
                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Description</label>
            <textarea name="description" rows="4"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500">{{ old('description', $product->description) }}</textarea>
            @error('description')
                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Base Price</label>
                <input type="number" step="0.01" name="base_price"
                    value="{{ old('base_price', $product->base_price) }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500"
                    required>
                @error('base_price')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Discounted Price</label>
                <input type="number" step="0.01" name="discounted_price"
                    value="{{ old('discounted_price', $product->discounted_price) }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500">
                @error('discounted_price')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Currency</label>
                <input type="text" name="currency" value="{{ old('currency', $product->currency ?? 'THB') }}"
                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500"
                    maxlength="3">
                @error('currency')
                    <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Image URL</label>
            <input type="url" name="image_url" value="{{ old('image_url', $product->image_url) }}"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500">
            @error('image_url')
                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <label class="inline-flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active))
                        class="rounded dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-teal-600 focus:ring-teal-500">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Active</span>
                </label>
                <label class="inline-flex items-center space-x-3 cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $product->is_featured))
                        class="rounded dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-teal-600 focus:ring-teal-500">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Featured</span>
                </label>
            </div>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button type="submit"
                class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition">Update</button>
            <a href="{{ route('admin.products.index') }}"
                class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">Back</a>
        </div>
    </form>
</x-layouts.admin.app>
