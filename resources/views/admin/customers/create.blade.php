<x-layouts.admin.app>
    <h1 class="text-2xl font-semibold mb-6">Create Customer</h1>

    <form action="{{ route('admin.customers.store') }}" method="POST"
        class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded shadow">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" class="w-full border rounded px-3 py-2"
                required>
            @error('name')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" class="w-full border rounded px-3 py-2"
                required>
            @error('email')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Password</label>
            <input type="password" name="password" class="w-full border rounded px-3 py-2" required>
            @error('password')
                <p class="text-red-600 text-sm">{{ $message }}</p>
            @enderror
        </div>

        <label class="inline-flex items-center space-x-2">
            <input type="checkbox" name="verified" value="1" @checked(old('verified'))>
            <span>Mark email as verified</span>
        </label>

        <div class="flex items-center gap-3">
            <button class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Save</button>
            <a href="{{ route('admin.customers.index') }}"
                class="px-4 py-2 bg-gray-200 dark:bg-gray-700 rounded">Cancel</a>
        </div>
    </form>
</x-layouts.admin.app>
