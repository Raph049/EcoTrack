<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('System Settings') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6 text-gray-900 dark:text-gray-100">
                
                <h3 class="text-lg font-medium text-red-600 dark:text-red-400 mb-4">
                    Admin Super User Area - Critical Configuration
                </h3>
                
                <p class="mb-2">
                    Placeholder: This area is reserved for changing global application variables, default statuses, and managing top-level users (Admin Secondary).
                </p>

            </div>
        </div>
    </div>
</x-app-layout>