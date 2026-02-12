<x-layouts.app>
    <div class="bg-gray-50 dark:bg-gray-900 min-h-screen py-12">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="flex justify-between items-center mb-8">
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Secure Booking</h1>
                <div class="flex space-x-2 text-sm">
                    <span class="text-teal-600 font-bold">1. Details</span>
                    <span class="text-gray-400">&rarr;</span>
                    <span class="text-gray-400">2. Payment</span>
                    <span class="text-gray-400">&rarr;</span>
                    <span class="text-gray-400">3. Done</span>
                </div>
            </div>

            <form action="{{ route('booking.store') }}" method="POST" x-data="{
                qty: 1,
                price: {{ $basePrice }},
                type: '{{ $serviceType }}',
                carServiceType: '{{ $carServiceType }}',
                charterHours: {{ $charterHours }},
                rates: {
                    airport_transfer: 1,
                    city_point_to_point: 1.15,
                    hourly_charter: 0.35
                },
                get unitPrice() {
                    if (this.type !== 'car') {
                        return this.price;
                    }
            
                    const rate = this.rates[this.carServiceType] ?? 1;
                    return this.price * rate;
                },
                get total() {
                    const hours = this.carServiceType === 'hourly_charter' ? this.charterHours : 1;
                    return this.unitPrice * this.qty * hours;
                }
            }">
                @csrf

                <input type="hidden" name="service_type" value="{{ $serviceType }}">
                <input type="hidden" name="product_name" value="{{ $productName }}">
                <input type="hidden" name="base_price" value="{{ $basePrice }}">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <div class="md:col-span-2 space-y-6">

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Contact Information
                            </h2>
                            <div class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Full
                                        Name</label>
                                    <input type="text" name="guest_name" value="{{ Auth::user()->name ?? '' }}"
                                        class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                        required>
                                </div>
                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Email</label>
                                        <input type="email" name="guest_email" value="{{ Auth::user()->email ?? '' }}"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            required>
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Phone
                                            (WhatsApp)</label>
                                        <input type="text" name="guest_phone"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            required placeholder="+66...">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm">
                            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Service Details</h2>
                            <div class="space-y-4">

                                <div x-show="type === 'car'" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Car
                                            Service</label>
                                        <select name="car_service_type" x-model="carServiceType"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                            <option value="airport_transfer">Airport transfer</option>
                                            <option value="city_point_to_point">City point-to-point</option>
                                            <option value="hourly_charter">Hourly charter</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-4">
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Date</label>
                                        <input type="date" name="service_date"
                                            value="{{ old('service_date', $serviceDate) }}"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            required>
                                    </div>
                                    <div>
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Time</label>
                                        <input type="time" name="service_time" value="{{ old('service_time') }}"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            required>
                                    </div>
                                </div>

                                <div x-show="type === 'car'" class="space-y-4">
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Flight
                                            Number (Airport Transfer)</label>
                                        <input type="text" name="flight_number"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            placeholder="e.g. TG 678">
                                    </div>
                                    <div>
                                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Pickup
                                            / Drop-off Details</label>
                                        <textarea name="pickup_location" rows="2"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            placeholder="Hotel name or Address">{{ old('pickup_location', $pickupLocation) }}</textarea>
                                    </div>
                                    <div x-show="carServiceType === 'city_point_to_point'">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Drop-off
                                            Location</label>
                                        <textarea name="dropoff_location" rows="2"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                            placeholder="Destination address">{{ old('dropoff_location', $dropoffLocation) }}</textarea>
                                    </div>
                                    <div x-show="carServiceType === 'hourly_charter'">
                                        <label
                                            class="block text-sm font-medium text-gray-700 dark:text-gray-300">Charter
                                            Duration (hours)</label>
                                        <input type="number" name="charter_hours" min="2" max="24"
                                            x-model="charterHours" value="{{ old('charter_hours', $charterHours) }}"
                                            class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700">
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                        x-text="type === 'car' ? 'Number of Cars' : 'Number of People'"></label>
                                    <input type="number" name="quantity" x-model="qty" min="1"
                                        class="mt-1 w-24 rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 text-center"
                                        required>
                                </div>

                                <div>
                                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Special
                                        Request (Optional)</label>
                                    <textarea name="special_request" rows="2"
                                        class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"></textarea>
                                </div>
                            </div>
                        </div>

                    </div>

                    <div class="md:col-span-1">
                        <div class="bg-white dark:bg-gray-800 p-6 rounded-xl shadow-sm sticky top-6">
                            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4">Booking Summary</h3>

                            <div class="mb-4 pb-4 border-b border-gray-100 dark:border-gray-700">
                                <p class="text-sm text-gray-500 dark:text-gray-400">Product</p>
                                <p class="font-medium text-gray-900 dark:text-white">{{ $productName }}</p>
                            </div>

                            <div class="flex justify-between mb-2 text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Price per unit</span>
                                <span class="text-gray-900 dark:text-white">THB <span
                                        x-text="unitPrice.toFixed(0)"></span>
                                    <span x-show="type === 'car' && carServiceType === 'hourly_charter'">/hr</span>
                                </span>
                            </div>
                            <div class="flex justify-between mb-4 text-sm">
                                <span class="text-gray-600 dark:text-gray-400">Quantity</span>
                                <span class="text-gray-900 dark:text-white">x <span x-text="qty"></span></span>
                            </div>

                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">Coupon
                                    Code</label>
                                <input type="text" name="coupon_code" value="{{ old('coupon_code') }}"
                                    class="mt-1 w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700"
                                    placeholder="MEMBER10">
                                @error('coupon_code')
                                    <p class="text-xs text-red-500 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div
                                class="pt-4 border-t border-gray-100 dark:border-gray-700 flex justify-between items-center mb-6">
                                <span class="text-lg font-bold text-gray-900 dark:text-white">Total</span>
                                <span class="text-xl font-bold text-teal-600">THB <span
                                        x-text="total.toLocaleString()"></span></span>
                            </div>

                            <button type="submit"
                                class="w-full bg-teal-600 hover:bg-teal-700 text-white font-bold py-3 px-4 rounded-lg shadow transition transform hover:-translate-y-0.5">
                                Proceed to Review
                            </button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
