<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Review;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create(Booking $booking): View
    {
        $this->authorizeBooking($booking);

        if ($booking->review) {
            abort(404);
        }

        return view('reviews.create', compact('booking'));
    }

    public function store(Request $request, Booking $booking): RedirectResponse
    {
        $this->authorizeBooking($booking);

        if ($booking->review) {
            return redirect()->route('booking.index');
        }

        $validated = $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
            'comment' => ['nullable', 'string', 'max:2000'],
        ]);

        Review::create([
            'booking_id' => $booking->id,
            'product_id' => $booking->product_id,
            'user_id' => $request->user()->id,
            'rating' => $validated['rating'],
            'comment' => $validated['comment'],
            'status' => 'approved',
        ]);

        $booking->update([
            'reviewed_at' => now(),
        ]);

        $this->updateProductStats($booking);

        return redirect()->route('booking.index')->with('status', 'Review submitted.');
    }

    private function authorizeBooking(Booking $booking): void
    {
        if ($booking->user_id !== Auth::user()->id() || $booking->payment_status !== 'paid') {
            abort(403);
        }
    }

    private function updateProductStats(Booking $booking): void
    {
        $product = $booking->product;
        if (!$product) {
            return;
        }

        $stats = $product->reviews()
            ->where('status', 'approved')
            ->selectRaw('COUNT(*) as total_reviews, AVG(rating) as average_rating')
            ->first();

        $product->update([
            'total_reviews' => (int) ($stats->total_reviews ?? 0),
            'average_rating' => round((float) ($stats->average_rating ?? 0), 2),
        ]);
    }
}
