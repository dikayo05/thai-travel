<x-layouts.admin.app>
    <div class="mb-6">
        <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Edit Customer</h1>
    </div>

    <form action="{{ route('admin.customers.update', $user) }}" method="POST"
        class="space-y-6 bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500"
                required>
            @error('name')
                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Email</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500"
                required>
            @error('email')
                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">New Password
                (optional)</label>
            <input type="password" name="password"
                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-teal-500 focus:border-teal-500">
            @error('password')
                <p class="text-red-600 dark:text-red-400 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
            <label class="inline-flex items-center space-x-3 cursor-pointer">
                <input type="checkbox" name="verified" value="1" @checked(old('verified', (bool) $user->email_verified_at))
                    class="rounded dark:bg-gray-700 border-gray-300 dark:border-gray-600 text-teal-600 focus:ring-teal-500">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">Email verified</span>
            </label>
        </div>

        <div class="flex items-center gap-3 pt-4 border-t border-gray-200 dark:border-gray-700">
            <button type="submit"
                class="px-4 py-2 bg-teal-600 hover:bg-teal-700 text-white font-medium rounded-lg transition">Update</button>
            <a href="{{ route('admin.customers.index') }}"
                class="px-4 py-2 bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">Back</a>
        </div>
    </form>
</x-layouts.admin.app>
