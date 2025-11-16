<?php

namespace App\Http\Controllers;

use App\Models\WasteRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestController extends Controller
{
    
    public function create()
    {
        return view('requests.create');
    }

    
    public function store(Request $request)
    {
        $request->validate([
            'waste_type' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'string', 'max:255'],
            'scheduled_time' => ['required', 'date', 'after:now'],
            'address' => ['required', 'string', 'max:500'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        // Create the new WasteRequest
        $wasteRequest = WasteRequest::create([
            'user_id' => Auth::id(), // Automatically assign the current authenticated user
            'waste_type' => $request->waste_type,
            'quantity' => $request->quantity,
            'scheduled_time' => $request->scheduled_time,
            'address' => $request->address,
            'notes' => $request->notes,
            'status' => 'Pending', // Default status upon submission
           
        ]);

        // Redirect the user to their history page with a success message
        return redirect()->route('requests.history')
                         ->with('status', 'Your collection request (ID: ' . $wasteRequest->id . ') has been submitted and is currently Pending review.');
    }

    
    public function history()
    {
        // Later: Fetch all requests submitted by the current user
        $requests = WasteRequest::where('user_id', Auth::id())
                                ->orderBy('created_at', 'desc')
                                ->get();

        return view('requests.history', compact('requests'));
    }

    
    public function show(WasteRequest $wasteRequest)
    {
        // Ensure the authenticated user owns this request before showing it
        if ($wasteRequest->user_id !== Auth::id()) {
            
            return redirect()->route('requests.history')
                             ->with('error', 'You are not authorized to view that request.');
        }

        return view('requests.show', compact('wasteRequest'));
    }
}
