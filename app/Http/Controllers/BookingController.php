<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Coupon;
use App\Models\CouponRedemption;
use App\Http\Requests\StoreBookingRequest;
use App\Http\Requests\UpdateBookingRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    private const POINTS_RATE = 0.01;

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bookings = Booking::query()
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(10);

        return view('bookings.index', compact('bookings'));
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
            'coupon_code' => 'nullable|string|max:40',
        ]);

        $subtotal = $request->base_price * $request->quantity;
        $user = $request->user();
        $coupon = null;
        $discount = 0;

        if ($request->filled('coupon_code')) {
            $coupon = Coupon::query()
                ->whereRaw('lower(code) = ?', [strtolower($request->coupon_code)])
                ->first();

            if (!$coupon || !$coupon->isActiveNow()) {
                return back()->withErrors(['coupon_code' => 'Kode kupon tidak valid atau sudah tidak aktif.'])->withInput();
            }

            $error = $this->validateCoupon($coupon, $user->id, $subtotal);
            if ($error) {
                return back()->withErrors(['coupon_code' => $error])->withInput();
            }

            $discount = $coupon->calculateDiscount($subtotal);
        }

        $totalPrice = max(0, $subtotal - $discount);

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
            'subtotal_price' => $subtotal,
            'discount_amount' => $discount,
            'total_price' => $totalPrice,
            'coupon_id' => $coupon?->id,
            'coupon_code' => $coupon?->code,

            'status' => 'pending',
            'payment_status' => 'unpaid',
            'special_request' => $request->special_request,
        ]);

        if ($coupon) {
            CouponRedemption::create([
                'coupon_id' => $coupon->id,
                'user_id' => $user->id,
                'booking_id' => $booking->id,
                'discount_amount' => $discount,
            ]);
        }

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

        $pointsToEarn = $this->calculatePoints((float) $booking->total_price);

        return view('bookings.payment', compact('booking', 'pointsToEarn'));
    }

    /**
     * Proses Pembayaran (Simulasi)
     */
    public function processPayment($id)
    {
        $booking = Booking::findOrFail($id);

        if (Auth::check() && $booking->user_id !== Auth::id()) {
            abort(403);
        }

        $pointsToEarn = $this->calculatePoints((float) $booking->total_price);

        if ($booking->points_earned === 0 && $pointsToEarn > 0 && $booking->user) {
            $booking->user->awardPoints($pointsToEarn);
        }

        // Simulasi update status
        $booking->update([
            'status' => 'confirmed',
            'payment_status' => 'paid',
            'points_earned' => $pointsToEarn,
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

    private function calculatePoints(float $amount): int
    {
        return (int) floor($amount * self::POINTS_RATE);
    }

    private function validateCoupon(Coupon $coupon, int $userId, float $subtotal): ?string
    {
        if ($coupon->min_spend && $subtotal < (float) $coupon->min_spend) {
            return 'Minimum transaksi belum terpenuhi untuk kupon ini.';
        }

        if ($coupon->max_uses) {
            $totalUses = $coupon->redemptions()->count();
            if ($totalUses >= $coupon->max_uses) {
                return 'Kupon sudah mencapai batas penggunaan.';
            }
        }

        if ($coupon->per_user_limit) {
            $userUses = $coupon->redemptions()->where('user_id', $userId)->count();
            if ($userUses >= $coupon->per_user_limit) {
                return 'Kupon ini sudah digunakan pada akun Anda.';
            }
        }

        return null;
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
