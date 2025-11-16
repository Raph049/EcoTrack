<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        // Fix: Removed trailing backtick/quote from the end of the line
        $user = Auth::user();

        // Admin Super User (Top priority, full access)
        if ($user->hasRole('admin super user')) {
            // Placeholder: Could be a dedicated admin summary page
            return redirect()->route('admin.reports');
        }

        // Waste Authority (Manages assignments)
        if ($user->hasRole('admin secondary')) {
            return redirect()->route('authority.assignments');
        }

        // Waste Collector (Manages assigned tasks)
        if ($user->hasRole('waste collector')) {
            return redirect()->route('collector.dashboard');
        }

        // Normal end user (Customer)
        return redirect()->route('requests.history');
    }
}
