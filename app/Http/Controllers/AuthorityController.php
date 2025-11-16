<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\WasteRequest;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;

class AuthorityController extends Controller
{
   
    public function index(): View
    {
  
        $requests = WasteRequest::with(['customer', 'collector']) 
            ->whereNotIn('status', ['Completed', 'Canceled'])
            ->orderBy('created_at', 'desc')
            ->get();

        // Fetch all users who have the 'admin secondary' role
        $collectors = User::role('admin secondary')->orderBy('name', 'asc')->get();

        return view('authority.assignments', compact('requests', 'collectors'));
    }

    
    public function trackingView(): View
    {
        
        return view('authority.tracking-updates');
    }

    
    public function assign(Request $request, int $requestId): RedirectResponse
    {
        $request->validate([

            'collector_id' => 'required|exists:users,id',
        ]);

        $wasteRequest = WasteRequest::findOrFail($requestId);
        
        // Ensure the request is still pending
        if ($wasteRequest->status === 'Pending') {
            $collectorId = $request->input('collector_id');
            
            // Assign the collector ID
            $wasteRequest->collector_id = $collectorId;
            $wasteRequest->status = 'Accepted'; // Automatically move to Accepted upon assignment
            
            // Record the Authority user who made the assignment
            $wasteRequest->assigned_authority_id = Auth::id();
            $wasteRequest->save();

            $collectorName = User::find($collectorId)->name;
            
            return redirect()->route('authority.assignments')
                ->with('status', "Request #{$requestId} has been successfully assigned to {$collectorName} and status updated to Accepted.");
        }

        return redirect()->route('authority.assignments')
            ->with('error', "Request #{$requestId} cannot be assigned as its status is already '{$wasteRequest->status}'.");
    }

   
    
    public function updateTracking(Request $request, int $requestId): RedirectResponse
    {
        $request->validate([
            'status' => 'required|in:Accepted,In Progress,Collected,Canceled',
        ]);
        
        $wasteRequest = WasteRequest::findOrFail($requestId);
        
        // Special case for 'Completed' status update
        if ($request->input('status') === 'Collected' && $wasteRequest->status !== 'Collected') {
            $wasteRequest->completion_time = now();
        } elseif ($wasteRequest->status === 'Collected' && $request->input('status') !== 'Collected') {
            // If they change status from completed, clear the completion_time timestamp
            $wasteRequest->completion_time = null;
        }

        $wasteRequest->status = $request->input('status');
        $wasteRequest->save();

        return redirect()->route('authority.assignments')
            ->with('status', "Request #{$requestId} status updated to {$wasteRequest->status} successfully.");
    }
}
