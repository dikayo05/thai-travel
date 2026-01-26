<x-layouts.guest>
    <div class="relative min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
        <!-- Background Image with Overlay -->
        <div class="absolute inset-0 w-full h-full bg-center bg-cover"
            style="background-image: url('https://images.unsplash.com/photo-1552465011-b4e21bf6e79a?q=80&w=2039&auto=format&fit=crop');">
            <span class="w-full h-full absolute opacity-50 bg-black dark:opacity-70"></span>
        </div>

        <!-- Login Card -->
        <div class="relative w-full max-w-md">
            <!-- Logo/Title Section -->
            <div class="text-center mb-8">
                <h1 class="text-4xl font-bold text-white drop-shadow-lg mb-2">
                    Welcome Back
                </h1>
                <p class="text-gray-200 drop-shadow-md">
                    Sign in to continue your Thailand adventure
                </p>
            </div>

            <!-- Login Form Card -->
            <div
                class="bg-white dark:bg-gray-800 rounded-xl shadow-2xl overflow-hidden border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <!-- Session Status -->
                    <x-auth-session-status class="mb-4" :status="session('status')" />

                    <form method="POST" action="{{ route('login') }}" class="space-y-6">
                        @csrf

                        <!-- Email Address -->
                        <div>
                            <label for="email"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Email Address
                            </label>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required
                                autofocus autocomplete="username"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary shadow-sm">
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Password
                            </label>
                            <input id="password" type="password" name="password" required
                                autocomplete="current-password"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white focus:ring-primary focus:border-primary shadow-sm">
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>

                        <!-- Remember Me & Forgot Password -->
                        <div class="flex items-center justify-between">
                            <label for="remember_me" class="inline-flex items-center">
                                <input id="remember_me" type="checkbox" name="remember"
                                    class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-primary shadow-sm focus:ring-primary dark:focus:ring-primary dark:focus:ring-offset-gray-800">
                                <span class="ml-2 text-sm text-gray-600 dark:text-gray-400">Remember me</span>
                            </label>

                            @if (Route::has('password.request'))
                                <a class="text-sm text-primary dark:text-teal-400 hover:text-teal-700 dark:hover:text-teal-300 font-medium"
                                    href="{{ route('password.request') }}">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit"
                                class="w-full bg-primary hover:bg-teal-700 text-white font-bold py-3 rounded-lg shadow-lg transition transform hover:-translate-y-0.5">
                                Sign In
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Register Link -->
                <div class="px-8 py-4 bg-gray-50 dark:bg-gray-900 border-t border-gray-100 dark:border-gray-700">
                    <p class="text-center text-sm text-gray-600 dark:text-gray-400">
                        Don't have an account?
                        <a href="{{ route('register') }}"
                            class="font-semibold text-primary dark:text-teal-400 hover:text-teal-700 dark:hover:text-teal-300">
                            Sign up for free
                        </a>
                    </p>
                </div>
            </div>

            <!-- Features -->
            <div class="mt-8 grid grid-cols-3 gap-4 text-center">
                <div class="text-white">
                    <div class="text-2xl mb-1">🚗</div>
                    <div class="text-xs drop-shadow-md">Premium Cars</div>
                </div>
                <div class="text-white">
                    <div class="text-2xl mb-1">🎯</div>
                    <div class="text-xs drop-shadow-md">Best Tours</div>
                </div>
                <div class="text-white">
                    <div class="text-2xl mb-1">⭐</div>
                    <div class="text-xs drop-shadow-md">Earn Points</div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.guest>
