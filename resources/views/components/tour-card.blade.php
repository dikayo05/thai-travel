@props([
    'image',
    'title',
    'badge' => null,
    'rating' => null,
    'reviews' => null,
    'duration' => null,
    'price' => null,
    'originalPrice' => null,
])

<div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden group">
    <div class="relative h-48 overflow-hidden">
        <img src="{{ $image }}" class="w-full h-full object-cover transition transform group-hover:scale-110"
            alt="{{ $title }}">
        @if ($badge)
            <div class="absolute top-2 right-2 bg-white/90 px-2 py-1 rounded text-xs font-bold text-gray-800">
                {{ $badge }}</div>
        @endif
    </div>
    <div class="p-5">
        @if ($rating !== null)
            <div class="flex items-center space-x-1 text-yellow-400 text-sm mb-2">
                @for ($i = 0; $i < $rating; $i++)
                    <span>★</span>
                @endfor
                @if ($reviews !== null)
                    <span class="text-gray-400 dark:text-gray-500">({{ $reviews }})</span>
                @endif
            </div>
        @endif
        <h3 class="text-lg font-bold mb-2 line-clamp-2 hover:text-primary cursor-pointer">{{ $title }}</h3>
        @if ($duration)
            <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">{{ $duration }}</p>
        @endif
        @if ($price)
            <div class="flex justify-between items-center">
                @if ($originalPrice)
                    <span class="text-gray-400 text-sm line-through">{{ $originalPrice }}</span>
                @endif
                <span class="text-xl font-bold text-primary">{{ $price }}</span>
            </div>
        @endif
    </div>
</div>
