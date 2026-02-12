<x-layouts.app>
    <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8">
                <div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Booking History</h1>
                    <p class="text-sm text-gray-500">Track your bookings, points, and review status.</p>
                </div>
                <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-xl px-5 py-3">
                    <div class="text-xs text-gray-500">Points Balance</div>
                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ auth()->user()->points_balance }}
                    </div>
                </div>
            </div>

            <div
                class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm overflow-hidden">
                <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Recent Bookings</h2>
                </div>
                <div class="divide-y divide-gray-100 dark:divide-gray-700">
                    @forelse ($bookings as $booking)
                        <div class="p-6 flex flex-col md:flex-row md:items-center md:justify-between gap-4">
                            <div>
                                <div class="text-sm text-gray-500">{{ $booking->booking_code }}</div>
                                <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $booking->product_name }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    {{ $booking->service_date?->format('d M Y') }}
                                    @if ($booking->service_time)
                                        • {{ \Carbon\Carbon::parse($booking->service_time)->format('H:i') }}
                                    @endif
                                </div>
                            </div>
                            <div class="text-sm text-gray-500">
                                <div>Status: <span
                                        class="font-medium text-gray-900 dark:text-white">{{ ucfirst($booking->status) }}</span>
                                </div>
                                <div>Payment: <span
                                        class="font-medium text-gray-900 dark:text-white">{{ ucfirst($booking->payment_status) }}</span>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="text-sm text-gray-500">Total</div>
                                <div class="text-lg font-semibold text-teal-600">THB
                                    {{ number_format($booking->total_price) }}</div>
                                @if ($booking->payment_status === 'paid' && $booking->reviewed_at === null)
                                    <a href="{{ route('reviews.create', $booking) }}"
                                        class="text-sm text-teal-600 hover:text-teal-700">Leave a review</a>
                                @elseif ($booking->reviewed_at)
                                    <span class="text-xs text-gray-500">Reviewed</span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="p-6 text-sm text-gray-500">No bookings yet.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-6">
                {{ $bookings->links() }}
            </div>
        </div>
    </section>
</x-layouts.app>
