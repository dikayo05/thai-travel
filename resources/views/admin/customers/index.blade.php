<x-layouts.admin.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Customers</h1>
        <a href="{{ route('admin.customers.create') }}"
            class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Create Customer</a>
    </div>

    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow-sm mb-6">
        <form method="GET" class="flex flex-col md:flex-row gap-4">
            <div class="w-full md:flex-1">
                <label class="block text-xs font-medium text-gray-700 dark:text-gray-300 mb-1">Search</label>
                <div class="relative">
                    <span class="absolute inset-y-0 left-0 flex items-center pl-3 text-gray-400">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search name or email..."
                        class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white pl-10 focus:ring-teal-500 focus:border-teal-500 text-sm">
                </div>
            </div>
            <div class="w-full md:w-auto flex items-end gap-2">
                <button type="submit"
                    class="px-4 py-2 text-sm bg-teal-600 text-white rounded-lg hover:bg-teal-700 transition">Search</button>
                <a href="{{ route('admin.customers.index') }}"
                    class="px-4 py-2 text-sm text-gray-600 dark:text-gray-300 bg-gray-100 dark:bg-gray-700 rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">Reset</a>
            </div>
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 shadow rounded overflow-hidden">
        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
            <thead class="bg-gray-50 dark:bg-gray-700">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium">Verified</th>
                    <th class="px-6 py-3 text-left text-xs font-medium">Joined</th>
                    <th class="px-6 py-3 text-right text-xs font-medium">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                @forelse($customers as $user)
                    <tr>
                        <td class="px-6 py-3">{{ $user->name }}</td>
                        <td class="px-6 py-3">{{ $user->email }}</td>
                        <td class="px-6 py-3">{{ $user->email_verified_at ? 'Yes' : 'No' }}</td>
                        <td class="px-6 py-3">{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="px-6 py-3 text-right space-x-2">
                            <a href="{{ route('admin.customers.edit', $user) }}"
                                class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">Edit</a>
                            <form action="{{ route('admin.customers.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700"
                                    onclick="return confirm('Delete this customer?')">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-6 text-center text-gray-500">No customers found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $customers->links() }}</div>
</x-layouts.admin.app>
