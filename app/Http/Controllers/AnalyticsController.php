<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\WasteRequest;
use App\Models\User;

class AnalyticsController extends Controller
{
    public function index()
    {
        // Total requests
        $totalRequests = WasteRequest::count();

        // Completed requests in the last 30 days
        $completedLast30Days = WasteRequest::where('status', 'Completed')
            ->where('updated_at', '>=', now()->subDays(30))
            ->count();

        // Total cancelled requests
        $totalCancelled = WasteRequest::where('status', 'Cancelled')->count();

        // Total clients
        $totalClients = User::count(); // Adjust if you only want certain roles, e.g., 'client'

        // Waste Type Distribution
        $wasteTypeDistribution = WasteRequest::select('waste_type')
            ->selectRaw('COUNT(*) as count')
            ->groupBy('waste_type')
            ->pluck('count', 'waste_type');

        // Pass all variables to the view
        return view('admin.reports', compact(
            'totalRequests',
            'completedLast30Days',
            'totalCancelled',
            'totalClients',
            'wasteTypeDistribution'
        ));
    }
}
