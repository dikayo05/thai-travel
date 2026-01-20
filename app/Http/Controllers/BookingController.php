<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $serviceType = $request->query('type', 'car');
        $productName = $request->query('product', 'Standard Sedan');
        $basePrice   = $request->query('price', 1000);

        return view('bookings.create', compact('serviceType', 'productName', 'basePrice'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreBookingRequest $request)
    {
        $request->validate([
            'guest_name' => 'required|string|max:255',
            'guest_email' => 'required|email',
            'guest_phone' => 'required|string',
            'service_date' => 'required|date|after_or_equal:today',
            'quantity' => 'required|integer|min:1',
            // Validasi kondisional (Car vs Tour)
            'flight_number' => 'nullable|required_if:service_type,car',
            'adult_pax' => 'nullable|integer',
        ]);

        $totalPrice = $request->base_price * $request->quantity;

        $booking = Booking::create([
            'user_id' => Auth::id(), // Null jika Guest
            'guest_name' => $request->guest_name,
            'guest_email' => $request->guest_email,
            'guest_phone' => $request->guest_phone,

            'service_type' => $request->service_type,
            'product_name' => $request->product_name,
            'product_id' => 0, // Placeholder jika belum ada tabel Product

            'service_date' => $request->service_date,
            'service_time' => $request->service_time,
            'pickup_location' => $request->pickup_location,
            'flight_number' => $request->flight_number,

            'quantity' => $request->quantity,
            'total_price' => $totalPrice,

            'status' => 'pending',
            'payment_status' => 'unpaid',
            'special_request' => $request->special_request,
        ]);

        return redirect()->route('booking.payment', $booking->id);
    }

    /**
     * Halaman Review & Payment
     */
    public function payment($id)
    {
        $booking = Booking::findOrFail($id);

        // Security check: Pastikan user hanya bisa melihat booking miliknya (jika login)
        if (Auth::check() && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        return view('bookings.payment', compact('booking'));
    }

    /**
     * Proses Pembayaran (Simulasi)
     */
    public function processPayment($id)
    {
        $booking = Booking::findOrFail($id);

        // Simulasi update status
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid'
        ]);

        return redirect()->route('booking.success', $booking->id);
    }

    /**
     * Halaman Sukses / Voucher
     */
    public function success($id)
    {
        $booking = Booking::findOrFail($id);
        return view('bookings.success', compact('booking'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Booking $booking)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Booking $booking)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateBookingRequest $request, Booking $booking)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Booking $booking)
    {
        //
    }
}
