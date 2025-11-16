@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-6">
            <h1 class="text-2xl font-bold mb-6 text-gray-800">
                Waste Collection Tracking
            </h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-800 px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            @if($wasteRequests->isEmpty())
                <p class="text-gray-600">No waste requests found for your authority.</p>
            @else
                <div class="overflow-x-auto">
                    <table class="min-w-full border border-gray-200">
                        <thead class="bg-gray-100 text-gray-700">
                            <tr>
                                <th class="py-2 px-4 text-left border-b">ID</th>
                                <th class="py-2 px-4 text-left border-b">Waste Type</th>
                                <th class="py-2 px-4 text-left border-b">Customer</th>
                                <th class="py-2 px-4 text-left border-b">Collector</th>
                                <th class="py-2 px-4 text-left border-b">Scheduled Time</th>
                                <th class="py-2 px-4 text-left border-b">Status</th>
                                <th class="py-2 px-4 text-left border-b">Completion Time</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-800">
                            @foreach($wasteRequests as $request)
                                <tr class="hover:bg-gray-50">
                                    <td class="py-2 px-4 border-b">{{ $request->id }}</td>
                                    <td class="py-2 px-4 border-b">{{ $request->waste_type }}</td>
                                    <td class="py-2 px-4 border-b">{{ $request->customer?->name ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $request->collector?->name ?? 'Unassigned' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $request->scheduled_time?->format('d M Y, H:i') ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b capitalize">{{ $request->status ?? 'N/A' }}</td>
                                    <td class="py-2 px-4 border-b">{{ $request->completion_time?->format('d M Y, H:i') ?? 'Pending' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
