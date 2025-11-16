<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Authority Assignments Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 lg:p-8 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">

                    <!-- Status/Error Message Display -->
                    @if (session('status'))
                        <div class="p-4 mb-4 text-sm text-green-800 bg-green-100 rounded-lg dark:bg-green-800 dark:text-green-100" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="p-4 mb-4 text-sm text-red-800 bg-red-100 rounded-lg dark:bg-red-800 dark:text-red-100" role="alert">
                            {{ session('error') }}
                        </div>
                    @endif

                    <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 mb-6">
                        Waste Collection Requests Awaiting Action ({{ $requests->count() }})
                    </h3>
                    
                    @if($requests->isEmpty())
                        <div class="text-center p-10 border border-dashed border-gray-300 dark:border-gray-600 rounded-lg">
                            <p class="text-gray-500 dark:text-gray-400">No pending or active requests at this time.</p>
                        </div>
                    @else
                        <!-- Assignments Table -->
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Customer</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waste Type</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Status</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assigned Collector</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Assignment Action</th>
                                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tracking Update</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($requests as $request)
                                        <tr>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                                {{ $request->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $request->customer->name }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $request->waste_type }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @php
                                                    $color = match($request->status) {
                                                        'Pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-100',
                                                        'Accepted' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-100',
                                                        'In Progress' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-100',
                                                        'Collected' => 'bg-orange-100 text-orange-800 dark:bg-orange-900 dark:text-orange-100',
                                                        default => 'bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300',
                                                    };
                                                @endphp
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $color }}">
                                                    {{ $request->status }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-gray-100">
                                                {{ $request->collector ? $request->collector->name : 'Unassigned' }}
                                            </td>
                                            
                                            <!-- Assignment Action Column -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                @if ($request->status === 'Pending')
                                                <form action="{{ route('authority.assign', $request->id) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    <select name="collector_id" required 
                                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm p-1.5 w-40">
                                                        <option value="">Assign Collector...</option>
                                                        @foreach($collectors as $collector)
                                                            <option value="{{ $collector->id }}">{{ $collector->name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <x-primary-button class="text-xs py-1.5 px-3">Assign</x-primary-button>
                                                </form>
                                                @else
                                                    <span class="text-gray-500 dark:text-gray-400 text-xs">Already assigned/active.</span>
                                                @endif
                                            </td>

                                            <!-- Tracking Update Column (THIS IS WHERE THE FIX IS APPLIED) -->
                                            <td class="px-6 py-4 whitespace-nowrap text-sm">
                                                <form action="{{ route('authority.updateTracking', $request->id) }}" method="POST" class="flex items-center space-x-2">
                                                    @csrf
                                                    @method('PUT')
                                                    
                                                    <select name="status" required 
                                                        class="border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 focus:border-indigo-500 dark:focus:border-indigo-600 focus:ring-indigo-500 dark:focus:ring-indigo-600 rounded-md shadow-sm text-sm p-1.5 w-40">
                                                        <option value="{{ $request->status }}">Current: {{ $request->status }}</option>
                                                        <option value="Accepted">Accepted</option>
                                                        <option value="In Progress">In Progress</option>
                                                        <option value="Collected">Collected</option>
                                                        <option value="Canceled">Canceled</option>
                                                    </select>
                                                    
                                                    <!-- THE BUTTON TO UPDATE-->
                                                    <x-primary-button class="text-xs py-1.5 px-3 bg-red-600 hover:bg-red-700 dark:bg-red-700 dark:hover:bg-red-600">
                                                        Update
                                                    </x-primary-button>
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
