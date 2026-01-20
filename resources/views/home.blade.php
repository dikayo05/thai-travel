<x-layouts.app>
    <div class="relative pt-16 pb-32 flex content-center items-center justify-center min-h-[85vh]">
        <div class="absolute top-0 w-full h-full bg-center bg-cover"
            style="background-image: url('https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?q=80&w=2039&auto=format&fit=crop');">
            <span class="w-full h-full absolute opacity-50 bg-black dark:opacity-70"></span>
        </div>

        <div class="container relative mx-auto px-4">
            <div class="items-center flex flex-wrap">
                <div class="w-full lg:w-8/12 px-4 ml-auto mr-auto text-center">
                    <h1 class="text-white font-bold text-4xl md:text-5xl lg:text-6xl drop-shadow-lg">
                        Experience Thailand <br> Like Never Before
                    </h1>
                    <p class="mt-4 text-lg text-gray-200 drop-shadow-md">
                        Premium Airport Transfers, City Tours, and Exclusive Experiences.
                    </p>
                </div>
            </div>

            <div class="mt-12 bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden max-w-4xl mx-auto border border-gray-100 dark:border-gray-700"
                x-data="{ activeTab: 'cars' }">
                <div class="flex border-b border-gray-200 dark:border-gray-700">
                    <button @click="activeTab = 'cars'"
                        :class="activeTab === 'cars' ? 'border-primary text-primary dark:text-teal-400 border-b-2' :
                            'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                        class="w-1/2 py-4 text-center font-semibold transition bg-gray-50 dark:bg-gray-900 hover:bg-white dark:hover:bg-gray-800">
                        🚗 Private Car / Transfer
                    </button>
                    <button @click="activeTab = 'tours'"
                        :class="activeTab === 'tours' ? 'border-primary text-primary dark:text-teal-400 border-b-2' :
                            'text-gray-500 hover:text-gray-700 dark:text-gray-400'"
                        class="w-1/2 py-4 text-center font-semibold transition bg-gray-50 dark:bg-gray-900 hover:bg-white dark:hover:bg-gray-800">
                        thailand Tours & Activities
                    </button>
                </div>

                <div x-show="activeTab === 'cars'" class="p-6 md:p-8"
                    x-transition:enter="transition ease-out duration-300"
                    x-transition:enter-start="opacity-0 transform scale-95"
                    x-transition:enter-end="opacity-100 transform scale-100">
                    <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Service
                                Type</label>
                            <select
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary focus:border-primary">
                                <option>Airport Transfer</option>
                                <option>City Rental (Hourly)</option>
                            </select>
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Pick-up
                                Location</label>
                            <input type="text" placeholder="e.g. Suvarnabhumi Airport"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary focus:border-primary">
                        </div>
                        <div class="md:col-span-1">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                            <input type="date"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary focus:border-primary">
                        </div>
                        <div class="md:col-span-1 flex items-end">
                            <button type="submit"
                                class="w-full bg-primary hover:bg-teal-700 text-white font-bold py-2.5 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                                Search Cars
                            </button>
                        </div>
                    </form>
                </div>

                <div x-show="activeTab === 'tours'" x-cloak class="p-6 md:p-8"
                    x-transition:enter="transition ease-out duration-300">
                    <form class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <div class="md:col-span-1">
                            <label
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Destination</label>
                            <select
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary focus:border-primary">
                                <option>Bangkok</option>
                                <option>Phuket</option>
                                <option>Chiang Mai</option>
                                <option>Pattaya</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Experience
                                Type</label>
                            <input type="text" placeholder="Temples, Food, Elephant Sanctuary..."
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 focus:ring-primary focus:border-primary">
                        </div>
                        <div class="md:col-span-1 flex items-end">
                            <button type="submit"
                                class="w-full bg-secondary hover:bg-yellow-600 text-white font-bold py-2.5 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                                Find Tours
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <section class="py-20 bg-white dark:bg-gray-900">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
                <div class="p-6 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <div
                        class="w-16 h-16 bg-teal-100 dark:bg-teal-900 rounded-full flex items-center justify-center mx-auto mb-4 text-primary dark:text-teal-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Punctual & Reliable</h3>
                    <p class="text-gray-600 dark:text-gray-400">Real-time flight tracking for airport pickups. We wait
                        for
                        you, free of charge for 60 mins.</p>
                </div>
                <div class="p-6 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <div
                        class="w-16 h-16 bg-teal-100 dark:bg-teal-900 rounded-full flex items-center justify-center mx-auto mb-4 text-primary dark:text-teal-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Verified Drivers</h3>
                    <p class="text-gray-600 dark:text-gray-400">Professional drivers with vetted backgrounds. Safe,
                        polite,
                        and familiar with the routes.</p>
                </div>
                <div class="p-6 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-800 transition">
                    <div
                        class="w-16 h-16 bg-teal-100 dark:bg-teal-900 rounded-full flex items-center justify-center mx-auto mb-4 text-primary dark:text-teal-400">
                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-xl font-bold mb-2">Seamless Payment</h3>
                    <p class="text-gray-600 dark:text-gray-400">Pay securely in THB with Credit Card. Earn points for
                        every
                        booking to save on your next trip.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gray-50 dark:bg-gray-800">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-end mb-8">
                <div>
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-white">Trending Tours</h2>
                    <p class="text-gray-600 dark:text-gray-400 mt-2">Handpicked experiences for you</p>
                </div>
                <a href="#" class="text-primary font-semibold hover:underline">View All &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1508009603885-50cf7c579365?q=80&w=1949&auto=format&fit=crop"
                            class="w-full h-full object-cover transition transform group-hover:scale-110"
                            alt="Bangkok Temple">
                        <div
                            class="absolute top-2 right-2 bg-white/90 px-2 py-1 rounded text-xs font-bold text-gray-800">
                            Day Tour</div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center space-x-1 text-yellow-400 text-sm mb-2">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span>★</span> <span
                                class="text-gray-400 dark:text-gray-500">(120)</span>
                        </div>
                        <h3 class="text-lg font-bold mb-2 line-clamp-2 hover:text-primary cursor-pointer">Grand Palace
                            &
                            Emerald Buddha Tour</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Duration: 4 Hours • English Guide</p>
                        <div class="flex justify-between items-center">
                            <span class="text-gray-400 text-sm line-through">THB 1,500</span>
                            <span class="text-xl font-bold text-primary">THB 1,200</span>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-900 rounded-xl shadow-lg overflow-hidden group">
                    <div class="relative h-48 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1537996194471-e657df975ab4?q=80&w=1938&auto=format&fit=crop"
                            class="w-full h-full object-cover transition transform group-hover:scale-110"
                            alt="Elephant">
                        <div
                            class="absolute top-2 right-2 bg-white/90 px-2 py-1 rounded text-xs font-bold text-gray-800">
                            Nature</div>
                    </div>
                    <div class="p-5">
                        <div class="flex items-center space-x-1 text-yellow-400 text-sm mb-2">
                            <span>★</span><span>★</span><span>★</span><span>★</span><span
                                class="text-gray-300">★</span>
                            <span class="text-gray-400 dark:text-gray-500">(85)</span>
                        </div>
                        <h3 class="text-lg font-bold mb-2 line-clamp-2 hover:text-primary cursor-pointer">Ethical
                            Elephant
                            Sanctuary Visit</h3>
                        <p class="text-sm text-gray-500 dark:text-gray-400 mb-4">Duration: 6 Hours • Lunch Included</p>
                        <div class="flex justify-between items-center">
                            <span class="text-xl font-bold text-primary">THB 2,500</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 bg-gradient-to-r from-teal-600 to-teal-800 text-white">
        <div class="container mx-auto px-4 flex flex-col md:flex-row items-center justify-between">
            <div class="md:w-1/2 mb-8 md:mb-0">
                <h2 class="text-3xl font-bold mb-4">Join thaiTravel Club</h2>
                <p class="text-teal-100 text-lg mb-6">Create an account today and get <span
                        class="font-bold text-yellow-400">300 Points</span> instantly! Collect points on every ride and
                    unlock exclusive discounts.</p>
                <ul class="space-y-2 mb-6">
                    <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                        </svg> Earn 1-3% cashback points</li>
                    <li class="flex items-center"><svg class="w-5 h-5 mr-2 text-yellow-400" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" />
                        </svg> Priority Customer Support</li>
                </ul>
                <a href="/register"
                    class="inline-block bg-white text-teal-800 font-bold px-8 py-3 rounded-lg hover:bg-gray-100 transition shadow-lg">Sign
                    Up for Free</a>
            </div>
            <div class="md:w-1/3">
                <div class="bg-white/10 backdrop-blur-sm p-6 rounded-2xl border border-white/20">
                    <div class="flex items-center justify-between mb-4">
                        <span class="text-sm uppercase tracking-wider text-teal-200">Membership Card</span>
                        <span class="font-mono text-yellow-400">GOLD TIER</span>
                    </div>
                    <div class="text-2xl font-bold mb-8">John Doe</div>
                    <div class="flex justify-between items-end">
                        <div>
                            <div class="text-xs text-teal-200">Points Balance</div>
                            <div class="text-xl font-bold">1,250 PTS</div>
                        </div>
                        <div class="h-8 w-8 bg-yellow-400 rounded-full"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</x-layouts.app>
