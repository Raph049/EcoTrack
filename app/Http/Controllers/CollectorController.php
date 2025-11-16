<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CollectorController extends Controller
{
    public function dashboard(): View
    {
        $collectorId = Auth::id();

        // Fetch requests assigned to the current collector, excluding Completed and Canceled
        $requests = WasteRequest::with('user')
            ->where('collector_id', $collectorId)
            ->whereNotIn('status', ['Completed', 'Canceled'])
            ->latest()
            ->get();

        return view('collector.dashboard', compact('requests'));
    }

    
    public function updateStatus(Request $request, WasteRequest $wasteRequest): RedirectResponse
    {
        $collectorId = Auth::id();

        // 1. Basic Validation - ADDED 'Collected' STATUS
        $request->validate([
            'status' => ['required', 'string', 'in:Accepted,In Progress,Collected,Canceled'],
        ]);

        // 2. Authorization Check: Ensure the request is assigned to this collector
        if ($wasteRequest->collector_id !== $collectorId) {
            return back()->with('error', 'Unauthorized action. You are not assigned to this request.');
        }

        // 3. Update Status
        $wasteRequest->update([
            'status' => $request->status,
        ]);

        return back()->with('status', "Request #{$wasteRequest->id} status updated to '{$request->status}'.");
    }
}
