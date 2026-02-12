<x-layouts.app>
    <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div class="grid md:grid-cols-3 gap-6">
                <div
                    class="md:col-span-2 bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Membership Dashboard</h1>
                    <p class="text-sm text-gray-500">Hello {{ $user->name }}, here is your membership status.</p>
                    <div class="mt-6 grid sm:grid-cols-3 gap-4">
                        <div
                            class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Tier</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ ucfirst($user->membership_tier) }}</div>
                        </div>
                        <div
                            class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Points Balance</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $user->points_balance }}
                            </div>
                        </div>
                        <div
                            class="bg-gray-50 dark:bg-gray-900 border border-gray-100 dark:border-gray-700 rounded-xl p-4">
                            <div class="text-xs text-gray-500">Lifetime Points</div>
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $user->lifetime_points }}</div>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Quick Links</h2>
                    <div class="mt-4 space-y-3 text-sm">
                        <a href="{{ route('booking.index') }}" class="block text-teal-600 hover:text-teal-700">Booking
                            History</a>
                        <a href="{{ route('support.chat') }}" class="block text-teal-600 hover:text-teal-700">Support
                            Chat</a>
                        <a href="{{ route('profile.edit') }}" class="block text-teal-600 hover:text-teal-700">Edit
                            Profile</a>
                    </div>
                </div>
            </div>

            <div class="grid lg:grid-cols-2 gap-6">
                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Active Coupons</h2>
                    <div class="space-y-3">
                        @forelse ($coupons as $coupon)
                            <div
                                class="flex items-center justify-between border border-gray-100 dark:border-gray-700 rounded-xl p-4">
                                <div>
                                    <div class="text-sm text-gray-500">Code</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $coupon->code }}
                                    </div>
                                    <div class="text-xs text-gray-500">
                                        {{ $coupon->type === 'percent' ? $coupon->value . '%' : 'THB ' . number_format($coupon->value) }}
                                        off</div>
                                </div>
                                <div class="text-xs text-gray-500 text-right">
                                    @if ($coupon->ends_at)
                                        Expires {{ $coupon->ends_at->format('d M Y') }}
                                    @else
                                        No expiry
                                    @endif
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No active coupons right now.</p>
                        @endforelse
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Reviews</h2>
                    <div class="space-y-3">
                        @forelse ($reviews as $review)
                            <div class="border border-gray-100 dark:border-gray-700 rounded-xl p-4">
                                <div class="text-sm text-gray-500">Booking #{{ $review->booking_id }}</div>
                                <div class="text-sm text-gray-900 dark:text-white">Rating: {{ $review->rating }} / 5
                                </div>
                                @if ($review->comment)
                                    <div class="text-xs text-gray-500 mt-1">{{ $review->comment }}</div>
                                @endif
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No reviews submitted yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-6">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Recent Bookings</h2>
                <div class="space-y-3">
                    @forelse ($bookings as $booking)
                        <div
                            class="flex items-center justify-between border border-gray-100 dark:border-gray-700 rounded-xl p-4">
                            <div>
                                <div class="text-sm text-gray-500">{{ $booking->booking_code }}</div>
                                <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                    {{ $booking->product_name }}</div>
                            </div>
                            <div class="text-sm text-gray-500">THB {{ number_format($booking->total_price) }}</div>
                        </div>
                    @empty
                        <p class="text-sm text-gray-500">No bookings yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
