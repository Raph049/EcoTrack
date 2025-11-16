<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Request Details') }} - #{{ $wasteRequest->id }}
            </h2>
            <a href="{{ route('requests.history') }}" class="text-indigo-600 dark:text-indigo-400 hover:text-indigo-900 dark:hover:text-indigo-600 text-sm font-medium">
                &larr; Back to History
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg p-8">

                <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6 border-b pb-3">
                    Collection Request Summary
                </h3>

                <!-- Status Badge (UPDATED with 'Collected' status) -->
                @php
                    $color = match($wasteRequest->status) {
                        'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300',
                        'Accepted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300',
                        'In Progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900/50 dark:text-purple-300',
                        'Collected' => 'bg-orange-100 text-orange-800 dark:bg-orange-900/50 dark:text-orange-300', // NEW STATUS COLOR
                        'Completed' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300',
                        'Cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300',
                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                    };
                @endphp
                <div class="mb-6">
                    <span class="text-lg font-semibold block text-gray-700 dark:text-gray-300">Current Status:</span>
                    <span class="px-3 py-1 inline-flex text-xl leading-5 font-bold rounded-lg {{ $color }}">
                        {{ $wasteRequest->status }}
                    </span>
                </div>

                <div class="space-y-6">
                    <!-- Waste and Quantity -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Waste Type</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $wasteRequest->waste_type }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Quantity</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $wasteRequest->quantity }}</p>
                        </div>
                    </div>

                    <!-- Scheduled Time & Submission Date -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Scheduled Time</p>
                            <p class="mt-1 text-lg font-semibold text-indigo-600 dark:text-indigo-400">{{ $wasteRequest->scheduled_time->format('F d, Y @ h:i A') }}</p>
                        </div>
                        <div>
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Submitted On</p>
                            <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-gray-100">{{ $wasteRequest->created_at->format('M d, Y') }}</p>
                        </div>
                    </div>

                    <!-- Address -->
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Collection Address</p>
                        <p class="mt-1 text-lg text-gray-900 dark:text-gray-100">{{ $wasteRequest->address }}</p>
                    </div>

                    <!-- Notes -->
                    @if ($wasteRequest->notes)
                    <div>
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Special Notes / Instructions</p>
                        <!-- CHANGED: Ensured dark mode text visibility for the note block -->
                        <p class="mt-1 p-3 bg-gray-50 dark:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300 italic">{{ $wasteRequest->notes }}</p>
                    </div>
                    @endif

                    <!-- Authority Assignment -->
                    <div class="pt-6 border-t dark:border-gray-700">
    <h4 class="text-xl font-semibold text-gray-700 dark:text-gray-300 mb-3">Assignment Details</h4>

    @if ($wasteRequest->status === 'Accepted')
        <div class="p-4 bg-blue-50 dark:bg-blue-900/50 rounded-lg text-blue-800 dark:text-white">
            <p class="font-medium dark:text-white">Request Accepted</p>
            <p class="text-sm mt-1 dark:text-gray-200">
                This request has been accepted by the waste authority team. A collector will be assigned soon.
            </p>
        </div>

    @elseif ($wasteRequest->status === 'Collected')
        <div class="p-4 bg-green-50 dark:bg-green-900/50 rounded-lg text-green-800 dark:text-white">
            <p class="font-medium dark:text-white">Request Completed</p>
            <p class="text-sm mt-1 dark:text-gray-200">
                The waste collection has been successfully completed. Thank you for keeping the environment clean!
            </p>
        </div>

    @elseif ($wasteRequest->status === 'Canceled')
        <div class="p-4 bg-red-50 dark:bg-red-900/50 rounded-lg text-red-800 dark:text-white">
            <p class="font-medium dark:text-white">Request Canceled</p>
            <p class="text-sm mt-1 dark:text-gray-200">
                This request was canceled and will not be collected.
            </p>
        </div>

    @else
        <div class="p-4 bg-yellow-50 dark:bg-yellow-900/50 rounded-lg text-yellow-800 dark:text-white">
            <p class="font-medium dark:text-white">Awaiting Assignment</p>
            <p class="text-sm mt-1 dark:text-gray-200">
                The waste authority team has not yet accepted and assigned a collector to this request.
            </p>
        </div>
    @endif
</div>


                </div>

            </div>
        </div>
    </div>
</x-app-layout>
