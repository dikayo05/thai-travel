<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Coupon;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MembershipController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        $bookings = Booking::query()
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $reviews = Review::query()
            ->where('user_id', $user->id)
            ->latest()
            ->take(5)
            ->get();

        $coupons = Coupon::query()
            ->active()
            ->orderBy('ends_at')
            ->get();

        return view('membership.account', compact('user', 'bookings', 'reviews', 'coupons'));
    }
}
