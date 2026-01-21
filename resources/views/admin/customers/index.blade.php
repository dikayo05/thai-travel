<x-layouts.admin.app>
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-2xl font-semibold">Customers</h1>
        <a href="{{ route('admin.customers.create') }}" class="px-4 py-2 bg-teal-600 text-white rounded hover:bg-teal-700">Create Customer</a>
    </div>

    <form method="GET" class="mb-4 flex gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name or email" class="flex-1 border rounded px-3 py-2" />
        <button class="px-4 py-2 bg-gray-800 text-white rounded hover:bg-gray-900">Search</button>
    </form>

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
                            <a href="{{ route('admin.customers.edit', $user) }}" class="px-3 py-1 bg-indigo-600 text-white rounded hover:bg-indigo-700">Edit</a>
                            <form action="{{ route('admin.customers.destroy', $user) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-600 text-white rounded hover:bg-red-700" onclick="return confirm('Delete this customer?')">Delete</button>
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
