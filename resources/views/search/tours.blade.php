<x-layouts.app>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <!-- Search Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Tours & Activities</h1>
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <div>
                        <span class="font-medium">Destination:</span>
                        <span class="capitalize">{{ str_replace('_', ' ', $destination) }}</span>
                    </div>
                    @if ($experienceType)
                        <div>
                            <span class="font-medium">Experience Type:</span>
                            <span>{{ $experienceType }}</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Tours Grid -->
            @if ($tours->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-600 dark:text-gray-400 text-lg">No tours available for your search criteria.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($tours as $tour)
                        <x-tour-card :image="$tour->image_url && str_starts_with($tour->image_url, 'http')
                            ? $tour->image_url
                            : ($tour->image_url
                                ? asset('storage/' . $tour->image_url)
                                : 'https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?q=80&w=1949&auto=format&fit=crop')" :title="$tour->name" :badge="$tour->destination ? ucfirst($tour->destination) : 'Tour'" :rating="(int) round($tour->average_rating)"
                            :reviews="(int) $tour->total_reviews" :duration="collect([
                                $tour->duration ? 'Duration: ' . $tour->duration : null,
                                $tour->includes_lunch ? 'Lunch Included' : null,
                                $tour->includes_pickup ? 'Pickup Included' : null,
                            ])
                                ->filter()
                                ->implode(' • ')" :price="$tour->currency . ' ' . number_format($tour->final_price)" :original-price="$tour->discounted_price
                                ? $tour->currency . ' ' . number_format($tour->base_price)
                                : null" />
                    @endforeach
                </div>
            @endif
</x-layouts.app>
