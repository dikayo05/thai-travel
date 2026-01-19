<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Booking;

class DashboardController extends Controller
{
    public function index()
    {
        // Hitung Statistik Sederhana
        $totalRevenue = Booking::where('payment_status', 'paid')->sum('total_price');
        $newBookings = Booking::where('status', 'pending')->count();
        $todaysBookings = Booking::whereDate('created_at', today())->count();
        $totalMembers = User::count();

        // Ambil 5 booking terbaru untuk widget "Recent Activity"
        $recentBookings = Booking::with('user')->latest()->take(5)->get();

        return view('admin.dashboard.index', compact(
            'totalRevenue',
            'newBookings',
            'todaysBookings',
            'totalMembers',
            'recentBookings'
        ));
    }
}
