<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<x-layouts.head />

<body class="font-sans antialiased bg-gray-100 dark:bg-gray-900 text-gray-900 dark:text-gray-100" x-data="{
    sidebarOpen: false,
    darkMode: localStorage.getItem('theme') === 'dark',
    toggleTheme() {
        this.darkMode = !this.darkMode;
        localStorage.setItem('theme', this.darkMode ? 'dark' : 'light');
        document.documentElement.classList.toggle('dark', this.darkMode);
    }
}"
    x-init="$watch('darkMode', val => document.documentElement.classList.toggle('dark', val));
    document.documentElement.classList.toggle('dark', darkMode);">

    <div class="flex h-screen overflow-hidden">

        <x-layouts.admin.sidebar />

        <div class="relative flex flex-col flex-1 overflow-y-auto overflow-x-hidden">

            <x-layouts.admin.header />

            <main class="w-full flex-grow p-6">
                {{ $slot }}
            </main>

        </div>
    </div>

</body>

</html>
