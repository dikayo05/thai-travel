<nav
    class="fixed w-full z-50 transition-all duration-300 bg-white/90 dark:bg-gray-900/90 backdrop-blur-md shadow-sm border-b border-gray-200 dark:border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16 items-center">
            <div class="flex-shrink-0 flex items-center">
                <span class="text-2xl font-bold text-primary dark:text-teal-400">Siam<span
                        class="text-secondary">Travel</span></span>
            </div>

            <div class="hidden md:flex space-x-8 items-center">
                <a href="#" class="hover:text-primary dark:hover:text-teal-400 transition">Cars</a>
                <a href="#" class="hover:text-primary dark:hover:text-teal-400 transition">Tours</a>
                <a href="#" class="hover:text-primary dark:hover:text-teal-400 transition">Membership</a>

                <button @click="toggleTheme()"
                    class="p-2 rounded-full hover:bg-gray-100 dark:hover:bg-gray-800 transition">
                    <svg x-show="!darkMode" class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <svg x-show="darkMode" x-cloak class="w-5 h-5 text-indigo-300" fill="none" stroke="currentColor"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20.354 24.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z">
                        </path>
                    </svg>
                </button>

                <a href="/login"
                    class="px-4 py-2 bg-primary hover:bg-teal-700 text-white rounded-lg transition">Login</a>
            </div>

            <div class="md:hidden flex items-center">
                <button class="text-gray-500 hover:text-gray-900 focus:outline-none">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</nav>
