<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $trendingTours = Product::tours()
            ->orderBy('is_featured', 'desc')
            ->orderBy('average_rating', 'desc')
            ->take(4)
            ->get();

        return view('home', compact('trendingTours'));
    }

    /**
     * Search for cars based on criteria
     */
    public function searchCars(Request $request)
    {
        $serviceType = $request->input('service_type', 'airport_transfer');
        $pickupLocation = $request->input('pickup_location', '');
        $serviceDate = $request->input('service_date', date('Y-m-d'));

        // Get all active cars from database
        $cars = Product::cars()->orderBy('is_featured', 'desc')->get();

        return view('search.cars', compact('cars', 'serviceType', 'pickupLocation', 'serviceDate'));
    }

    /**
     * Search for tours based on criteria
     */
    public function searchTours(Request $request)
    {
        $destination = $request->input('destination', 'bangkok');
        $experienceType = $request->input('experience_type', '');

        // Get tours from database with optional filtering
        $query = Product::tours()->orderBy('is_featured', 'desc');

        if ($destination && $destination !== 'all') {
            $query->where('destination', 'like', '%' . ucfirst(str_replace('_', ' ', $destination)) . '%');
        }

        if ($experienceType) {
            $query->where(function ($q) use ($experienceType) {
                $q->where('name', 'like', '%' . $experienceType . '%')
                    ->orWhere('description', 'like', '%' . $experienceType . '%');
            });
        }

        $tours = $query->get();

        return view('search.tours', compact('tours', 'destination', 'experienceType'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
