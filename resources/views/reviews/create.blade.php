<x-layouts.app>
    <section class="py-12 bg-gray-50 dark:bg-gray-900 min-h-screen">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl shadow-sm p-6">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-2">Leave a Review</h1>
                <p class="text-sm text-gray-500 mb-6">Share your experience for {{ $booking->product_name }}.</p>

                <form method="POST" action="{{ route('reviews.store', $booking) }}" class="space-y-5">
                    @csrf

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Rating</label>
                        <select name="rating"
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                            required>
                            <option value="">Select rating</option>
                            @for ($i = 5; $i >= 1; $i--)
                                <option value="{{ $i }}" @selected(old('rating') == $i)>{{ $i }}
                                    star</option>
                            @endfor
                        </select>
                        @error('rating')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Comment
                            (optional)</label>
                        <textarea name="comment" rows="4"
                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">{{ old('comment') }}</textarea>
                        @error('comment')
                            <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-3">
                        <button type="submit"
                            class="bg-teal-600 hover:bg-teal-700 text-white font-semibold px-5 py-2.5 rounded-lg">Submit
                            Review</button>
                        <a href="{{ route('booking.index') }}"
                            class="text-sm text-gray-500 hover:text-gray-700">Cancel</a>
                    </div>
                </form>
            </div>
        </div>
    </section>
</x-layouts.app>
