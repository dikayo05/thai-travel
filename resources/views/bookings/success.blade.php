<x-layouts.app>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen flex items-center justify-center py-12">
        <div class="max-w-md w-full bg-white dark:bg-gray-800 shadow-2xl rounded-2xl p-8 text-center">

            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-6">
                <svg class="w-10 h-10 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>

            <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Booking Confirmed!</h1>
            <p class="text-gray-500 mb-8">Thank you for your order. We have sent the confirmation email to <span
                    class="font-semibold">{{ $booking->guest_email }}</span>.</p>

            <div
                class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg border-2 border-dashed border-gray-300 dark:border-gray-500 mb-8">
                <p class="text-xs text-gray-500 dark:text-gray-400 uppercase tracking-wide">Booking Reference</p>
                <p class="text-2xl font-mono font-bold text-gray-900 dark:text-white">{{ $booking->booking_code }}</p>
            </div>

            @if ($booking->points_earned > 0)
                <div class="mb-6 text-sm text-gray-600 dark:text-gray-300">
                    You earned <span
                        class="font-semibold text-gray-900 dark:text-white">{{ $booking->points_earned }}</span>
                    points from this booking.
                </div>
            @endif

            <div class="space-y-3">
                <a href="#"
                    class="block w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 rounded-lg transition">
                    Download Voucher (PDF)
                </a>
                @if ($booking->payment_status === 'paid' && $booking->reviewed_at === null)
                    <a href="{{ route('reviews.create', $booking) }}"
                        class="block w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-bold py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                        Leave a Review
                    </a>
                @endif
                <a href="/"
                    class="block w-full bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-bold py-3 rounded-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    Back to Home
                </a>
            </div>

        </div>
    </div>
</x-layouts.app>
