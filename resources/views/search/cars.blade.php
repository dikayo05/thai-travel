<x-layouts.app>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
        <div class="container mx-auto px-4">
            <!-- Search Summary -->
            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6 mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white mb-4">Available Cars</h1>
                <div class="flex flex-wrap gap-4 text-sm text-gray-600 dark:text-gray-400">
                    <div>
                        <span class="font-medium">Service Type:</span>
                        <span class="capitalize">{{ str_replace('_', ' ', $serviceType) }}</span>
                    </div>
                    @if ($pickupLocation)
                        <div>
                            <span class="font-medium">Pickup Location:</span>
                            <span>{{ $pickupLocation }}</span>
                        </div>
                    @endif
                    <div>
                        <span class="font-medium">Date:</span>
                        <span>{{ \Carbon\Carbon::parse($serviceDate)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>

            <!-- Car Options Grid -->
            @if ($cars->isEmpty())
                <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-12 text-center">
                    <p class="text-gray-600 dark:text-gray-400 text-lg">No cars available at the moment.</p>
                </div>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    @foreach ($cars as $car)
                        <div
                            class="bg-white dark:bg-gray-800 rounded-xl shadow-lg overflow-hidden hover:shadow-xl transition">
                            <div
                                class="relative h-48 bg-gradient-to-br from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-800">
                                <img src="{{ $car->image_url }}" class="w-full h-full object-cover"
                                    alt="{{ $car->name }}">
                                @if ($car->is_featured)
                                    <div
                                        class="absolute top-4 right-4 bg-teal-500 text-white px-3 py-1 rounded-full text-xs font-bold">
                                        Most Popular
                                    </div>
                                @endif
                            </div>
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-gray-900 dark:text-white mb-2">{{ $car->name }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                    {{ $car->car_model }} • {{ $car->max_passengers }} passengers •
                                    {{ $car->max_luggage }} luggage
                                </p>

                                <div class="flex items-center text-yellow-400 text-sm mb-4">
                                    @for ($i = 0; $i < floor($car->average_rating); $i++)
                                        <span>★</span>
                                    @endfor
                                    @if ($car->average_rating - floor($car->average_rating) >= 0.5)
                                        <span>★</span>
                                    @endif
                                    <span class="text-gray-500 ml-2">({{ number_format($car->total_reviews) }}
                                        reviews)</span>
                                </div>

                                <div class="border-t border-gray-200 dark:border-gray-700 pt-4 mb-4">
                                    <div class="flex justify-between items-center mb-2">
                                        @if ($car->discounted_price)
                                            <div>
                                                <span class="text-gray-400 line-through text-sm">{{ $car->currency }}
                                                    {{ number_format($car->base_price) }}</span>
                                            </div>
                                            <span
                                                class="text-2xl font-bold text-primary dark:text-teal-400">{{ $car->currency }}
                                                {{ number_format($car->discounted_price) }}</span>
                                        @else
                                            <span class="text-gray-600 dark:text-gray-400">Base Price</span>
                                            <span
                                                class="text-2xl font-bold text-primary dark:text-teal-400">{{ $car->currency }}
                                                {{ number_format($car->base_price) }}</span>
                                        @endif
                                    </div>
                                </div>

                                <a href="{{ route('booking.create', ['type' => 'car', 'product' => $car->name, 'price' => $car->final_price, 'service_type' => $serviceType, 'pickup' => $pickupLocation, 'date' => $serviceDate]) }}"
                                    class="block w-full bg-primary hover:bg-teal-700 text-white text-center font-bold py-3 rounded-lg transition">
                                    Book Now
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif

            <!-- Info Section -->
            <div class="mt-12 bg-teal-50 dark:bg-teal-900/20 rounded-lg p-6">
                <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">📋 What's Included:</h3>
                <ul class="grid grid-cols-1 md:grid-cols-2 gap-3 text-sm text-gray-700 dark:text-gray-300">
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                        </svg>
                        Professional English-speaking driver
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                        </svg>
                        Free 60-min waiting time for airport pickups
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                        </svg>
                        Fuel, tolls, and parking fees included
                    </li>
                    <li class="flex items-center">
                        <svg class="w-5 h-5 mr-2 text-teal-600" fill="currentColor" viewBox="0 0 20 20">
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                        </svg>
                        24/7 customer support
                    </li>
                </ul>
            </div>
        </div>
    </div>
</x-layouts.app>
