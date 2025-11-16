<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Reports & Analytics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

           

            <!-- Waste Type Distribution -->
            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4 text-indigo-600">Waste Type Distribution</h3>
                @if($wasteTypeDistribution->isNotEmpty())
                    <ul class="list-disc list-inside text-gray-600 dark:text-gray-300">
                        @foreach($wasteTypeDistribution as $type => $count)
                            <li>{{ ucfirst($type) }} — {{ $count }}</li>
                        @endforeach
                    </ul>
                @else
                    <p class="text-gray-500">No data available yet.</p>
                @endif
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Requests</h3>
        <p class="text-3xl font-bold text-indigo-600">{{ $totalRequests }}</p>
    </div>
    
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Completed (Last 30 Days)</h3>
        <p class="text-3xl font-bold text-green-500">{{ $completedLast30Days }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Cancelled</h3>
        <p class="text-3xl font-bold text-red-500">{{ $totalCancelled }}</p>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
        <h3 class="text-gray-500 text-sm">Total Clients</h3>
        <p class="text-3xl font-bold text-yellow-500">{{ $totalClients }}</p>
    </div>
</div>


            <!-- Collector Performance -->{{-- Collector Performance section removed for now 

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow">
                <h3 class="text-lg font-medium mb-4 text-indigo-600">Top Collectors</h3>
                @if($collectorPerformance->isNotEmpty())
                    <table class="min-w-full text-sm">
                        <thead class="bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-200">
                            <tr>
                                <th class="py-2 px-4 text-left">Collector</th>
                                <th class="py-2 px-4 text-left">Completed Requests</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($collectorPerformance as $collector)
                                <tr class="border-b border-gray-200 dark:border-gray-700">
                                    <td class="py-2 px-4">{{ $collector->name }}</td>
                                    <td class="py-2 px-4">{{ $collector->completed_requests_count }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="text-gray-500">No collector data available.</p>
                @endif
            </div>--}}

        </div>
    </div>
</x-app-layout>
