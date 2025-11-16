<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('My Assigned Collection Tasks') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <!-- Status Message Display -->
                    @if (session('status'))
                        <div class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-100" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">Active Assignments ({{ $requests->whereNotIn('status', ['Completed', 'Canceled'])->count() }})</h3>
                    
                    @if($requests->isEmpty())
                        <div class="text-center p-10 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">You currently have no active assignments. Check back later!</p>
                        </div>
                    @else
                        <!-- Assignments Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waste Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Scheduled Time</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Current Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Action</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($requests as $request)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $request->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $request->waste_type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ \Carbon\Carbon::parse($request->scheduled_time)->format('Y-m-d H:i') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @php
                                                    $color = match($request->status) {
                                                        'Assigned' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100',
                                                        'In Progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100',
                                                        'Completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-100',
                                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                    };
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                    {{ $request->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <form action="{{ route('collector.update-status', $request->id) }}" method="POST" class="inline-flex space-x-2">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    @if ($request->status === 'Assigned')
                                                        <!-- Option 1: Start Collection -->
                                                        <input type="hidden" name="status" value="In Progress">
                                                        <button type="submit" class="text-indigo-600 hover:text-indigo-900 dark:text-indigo-400 dark:hover:text-indigo-300 font-bold border-2 border-indigo-600 dark:border-indigo-400 rounded-lg px-3 py-1 transition duration-150 ease-in-out hover:bg-indigo-50 dark:hover:bg-gray-700">
                                                            Start Collection
                                                        </button>
                                                    @elseif ($request->status === 'In Progress')
                                                        <!-- Option 2: Complete Collection -->
                                                        <input type="hidden" name="status" value="Completed">
                                                        <button type="submit" class="text-green-600 hover:text-green-900 dark:text-green-400 dark:hover:text-green-300 font-bold border-2 border-green-600 dark:border-green-400 rounded-lg px-3 py-1 transition duration-150 ease-in-out hover:bg-green-50 dark:hover:bg-gray-700">
                                                            Complete Task
                                                        </button>
                                                    @else
                                                        <!-- Default state for Completed/Cancelled tasks -->
                                                        <span class="text-gray-400 dark:text-gray-600 px-3 py-1">No Action</span>
                                                    @endif
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
