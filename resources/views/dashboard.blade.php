<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
        <div class="relative bg-green-50 rounded-3xl shadow-xl overflow-hidden max-w-6xl mx-auto mt-8 p-8">
    <!-- Background leaves -->
    <div class="absolute top-0 left-0 w-48 h-48 bg-green-200 rounded-full opacity-30 animate-pulse"></div>
    <div class="absolute bottom-0 right-0 w-64 h-64 bg-green-300 rounded-full opacity-20 animate-pulse"></div>

    <!-- Content -->
    <div class="relative z-10">
        <div class="flex items-center space-x-4">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-green-700" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 2C8.13 2 5 5.13 5 9c0 3.87 3.13 7 7 7s7-3.13 7-7c0-3.87-3.13-7-7-7zM12 21v-4" />
            </svg>
            <h2 class="text-3xl font-bold text-green-900">Welcome to EcoTrack</h2>
        </div>

        <p class="mt-4 text-green-800 text-lg">
            Keep your environment clean and green! Track your waste collection requests, report issues, and make your community more sustainable. 🌱
        </p>

        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-green-100 p-5 rounded-xl text-center shadow-md hover:bg-green-200 transition transform hover:-translate-y-1">
                <h3 class="font-semibold text-green-900 mb-2">My Requests</h3>
                <p class="text-green-800">Check the status of your waste collection requests and see completed and pending tasks.</p>
            </div>
            <div class="bg-green-100 p-5 rounded-xl text-center shadow-md hover:bg-green-200 transition transform hover:-translate-y-1">
                <h3 class="font-semibold text-green-900 mb-2">Report an Issue</h3>
                <p class="text-green-800">Quickly notify us about missed pickups or waste management issues in your area.</p>
            </div>
            <div class="bg-green-100 p-5 rounded-xl text-center shadow-md hover:bg-green-200 transition transform hover:-translate-y-1">
                <h3 class="font-semibold text-green-900 mb-2">Eco Tips</h3>
                <p class="text-green-800">Learn how to reduce, reuse, and recycle more efficiently in your daily life.</p>
            </div>
        </div>
    </div>
</div>

    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in!") }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
